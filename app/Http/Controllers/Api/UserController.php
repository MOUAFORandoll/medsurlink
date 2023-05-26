<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\PersonnnalException;
use App\Http\Controllers\Traits\PersonnalErrors;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Mail\Password\PasswordGenerated;
use App\Mail\Password\PatientPasswordGenerated;
use App\Mail\updateSetting;
use App\Models\Souscripteur;
use App\Models\TimeActivite;
use App\Rules\EmailExistRule;
use App\Traits\SmsTrait;
use App\User;
use Carbon\Carbon;
use http\Env\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Netpok\Database\Support\DeleteRestrictionException;
use PHPUnit\Util\Json;

class UserController extends Controller
{
    use PersonnalErrors;
    use SmsTrait;
    protected $table = 'users';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        foreach ($users as $user) {
            $user->roles;
        }
        return response()->json(['users' => $users]);
    }

    public function getPatientAndSouscripteur()
    {
        $users = User::with('souscripteur', 'patient')->get();
        return response()->json(['users' => $users]);
    }

    // public function getUserWithPermissions(Request $request)
    // {
    //     $size = $request->size ? $request->size : 10;
    //     $users = User::with('roles')->paginate($size);
    //     return response()->json(['users' => $users]);
    // }

    public function getUserWithPermissions(Request $request)
    {
        $size = $request->size ? $request->size : 10;
        $search = $request->search;

        $query = User::with('roles');

        if ($search) {
            $query->where('nom', 'LIKE', "%$search%")
                ->orWhere('prenom', 'LIKE', "%$search%");
        }

        $users = $query->paginate($size);

        return response()->json(['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = self::generatedUser($request);
        return response()->json(['user' => $user->getOriginalContent()]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $validation = $this->validatedSlug($slug);
        if (!is_null($validation))
            return $validation;
        $user = User::findBySlug($slug);
        $user->roles;
        return response()->json(['user' => $user]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function getOneUser($slug)
    // {
    //     $user = User::with('roles.permissions', 'all_permissions')->whereSlug($slug)->first();

    //     if (!$user) {
    //         return response()->json(['error' => 'Utilisateur non trouvé'], 404);
    //     }
    //     return response()->json(['user' => $user]);
    // }

    public function getOneUser($slug)
    {
        $user = User::with('roles.permissions', 'all_permissions', 'permissions')->whereSlug($slug)->first();

        if (!$user) {
            return response()->json(['error' => 'Utilisateur non trouvé'], 404);
        }

        // Fusionner les collections roles.permissions et permissions
        $mergedPermissions = $user->roles->flatMap(function ($role) {
            return $role->permissions;
        })->merge($user->all_permissions)->unique('id')
            ->merge($user->permissions)->unique('id')
            ->toArray();

        // Transformer la collection en tableau
        $mergedPermissions = array_values($mergedPermissions);

        // Attribuer la collection fusionnée à une propriété du modèle User
        $user->mergedPermissions = $mergedPermissions;

        return response()->json(['user' => $user]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $slug)
    {
        if ($request->has('error')) {
            return  response()->json(['error' => $request->all()['error']], 419);
        }

        // $validation = $this->validatedSlug($slug);
        // if(!is_null($validation))
        //     return $validation;

        $this->validatedSlug($slug, $this->table);

        $user = User::whereSlug($request->slug)->first()->update($request->all());

        // $user = User::whereSlug($slug)->first();
        // $user->nom = $request->nom;
        // $user->prenom = $request->prenom;
        // $user->email = $request->email;
        // $user->telephone = $request->telephone;
        // $user->pays = $request->pays;
        // $user->code_postal = $request->code_postal;
        // $user->quartier = $request->quartier;
        // $user->adresse = $request->adresse;
        // $user->ville = $request->ville;
        // $user->save();
        // $user->update();
        // dd($request->all());
        \Log::alert($user);

        return response()->json(['user' => $user]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        $validation = $this->validatedSlug($slug);
        if (!is_null($validation))
            return $validation;

        try {
            $user = User::findBySlug($slug);
            $user->delete();
            return response()->json(['user' => $user]);
        } catch (DeleteRestrictionException $deleteRestrictionException) {
            $this->revealError('deletingError', $deleteRestrictionException->getMessage());
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function validatedSlug($slug)
    {
        $validation = Validator::make(compact('slug'), ['slug' => 'exists:users,slug']);
        if ($validation->fails()) {
            return response()->json($validation->errors(), 422);
        }
        return null;
    }


    public static function generatedUser($request, $role = null)
    {

        $validation = self::personalValidation($request->all(), $role);

        if ($validation->fails())
            throw new ValidationException($validation, $validation->errors());

        $password = str_random(10);
        $code = "";
        $email = $request->email;
        $isMedicasure = $request->get('isMedicasure', '0');

        if (!is_null($role) && $role == "Patient") {
            $date_naissance = Carbon::parse($request->date_de_naissance)->year;
            $code = substr($password, 0, 5);
            $password = $date_naissance . $code;

            //Si l'email est null
            if (is_null($email) && $isMedicasure && !is_null($request->souscripteur_id)) {
                $souscripteur =  Souscripteur::with('user')->where('user_id', '=', $request->souscripteur_id)->first();
                $email = $souscripteur->user->email;
            }
        }
        $slack = "";
        if (!is_null($request->slack)) {
            $slack = $request->slack;
        }
        $user = User::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $email,
            'nationalite' => $request->nationalite,
            'quartier' => $request->quartier,
            'code_postal' => $request->code_postal,
            'ville' => $request->ville,
            'pays' => $request->pays,
            'telephone' => $request->telephone,
            'adresse' => $request->adresse,
            'slack' => $slack,
            'isMedicasure' => $request->get('isMedicasure', '0'),
            'isNotice' => $request->get('isNotice', '0'),
            'password' => Hash::make($password),
            'decede' => 'non'
        ]);
        if (!is_null($role) && $role == "Patient") {
            $user->smsEnvoye = 1;
            $user->save();
        }

        if (!is_null($role) && $role == "Souscripteur") {
            $user->isMedicasure = 1;
            $user->save();
        }
        return response()->json(['user' => $user, 'password' => $password, 'code' => $code]);
    }
    public static function generatedUserFromMedicasure($request, $role = null)
    {

        $password = str_random(10);
        $code = "";
        $email = $request->email;
        $isMedicasure = $request->get('isMedicasure', '0');

        if (!is_null($role) && $role == "Patient") {
            $date_naissance = Carbon::parse($request->date_de_naissance)->year;
            $code = substr($password, 0, 5);
            $password = $date_naissance . $code;

            //Si l'email est null
            if (is_null($email) && $isMedicasure && !is_null($request->souscripteur_id)) {
                $souscripteur =  Souscripteur::with('user')->where('user_id', '=', $request->souscripteur_id)->first();
                $email = $souscripteur->user->email;
            }
        }
        $slack = "";
        if (!is_null($request->slack)) {
            $slack = $request->slack;
        }
        $user = User::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $email,
            'nationalite' => $request->nationalite,
            'quartier' => $request->quartier,
            'code_postal' => $request->code_postal,
            'ville' => $request->ville,
            'pays' => $request->pays,
            'telephone' => $request->telephone,
            'adresse' => $request->adresse,
            'slack' => $slack,
            'isMedicasure' => $request->isMedicasure,
            'isNotice' => 0,
            'password' => Hash::make($password),
            'decede' => 'non'
        ]);
        if (!is_null($role) && $role == "Patient") {
            $user->smsEnvoye = 1;
            $user->save();
        }

        if (!is_null($role) && $role == "Souscripteur") {
            $user->isMedicasure = 1;
            $user->save();
        }
        return response()->json(['user' => $user, 'password' => $password, 'code' => $code]);
    }
    public static function sendUserInformationViaMail(User $user, $password)
    {
        if (!is_null($user->email)) {
            $mail = new PasswordGenerated($user, $password);
            $when = now()->addMinutes(1);
            Mail::to($user->email)->later($when, $mail);
        }
    }
    public static function sendUserPatientInformationViaMail(User $user, $password)
    {
        if (!is_null($user)) {
            if (!is_null($user->email)) {
                $mail = new PatientPasswordGenerated($user, $password);
                $when = now()->addMinutes(1);
                Mail::to($user->email)->later($when, $mail);
            }
        }
    }

    public static function updatePersonalInformation($data, $slug)
    {
        $validation = self::personalUpdateValidation($data, $slug);

        if ($validation->fails())
            throw new ValidationException($validation, $validation->errors());

        $user = User::findBySlug($slug);
        if ($user->getRoleNames()->first() == 'Patient') {

            $user = User::with('patient')->whereSlug($slug)->first();

            $response = 0;

            // Get all patients where the name and surname are the same
            if (
                !is_null($data['nom'])
                && !is_null($data['prenom'])

                // Check if the name or the surname has changed
                && ($data['nom'] != $user->nom
                    || $data['prenom'] != $user->prenom
                )
            ) {
                $response = User::with('patient')->where([
                    ['nom', '=', $data['nom']],
                    ['prenom', '=', $data['prenom']],
                    ['telephone', '=', $data['telephone']],
                ])->count();
            }

            // Check if is greater than zero
            //            if($response > 0) {
            //                // If so, return an error
            //                return response()->json([
            //                    'user'=> null,
            //                    'error' => trans('validation.duplicate_patient_name')
            //                ]);
            //            }


            if ($data['telephone'] != $user->telephone || $data['date_de_naissance'] != $user->patient->date_de_naissance) {
                $password = str_random(10);
                $code = "";
                $date_naissance = Carbon::parse($data['date_de_naissance'])->year;
                $code = substr($password, 0, 5);
                $password = $date_naissance . $code;
                //                $nom = (is_null($data['prenom']) ? "" : ucfirst($data['prenom']) ." ") . "". strtoupper( $data['nom']);
                $nom = substr(strtoupper($user->nom), 0, 9);
                sendSMS($data['telephone'], trans('sms.accountSecurityUpdated', ['nom' => $nom, 'password' => $code], 'fr'));
                $data['password'] = bcrypt($password);
                //Ici on va mettre la restriction en cas de non envoi de sms
                $data['smsEnvoye'] = $user->smsEnvoye + 1;
            }
            unset($data['date_de_naissance']);
        }

        User::whereSlug($slug)->update($data);
        $user = User::findBySlug($slug);

        return response()->json(['user' => $user]);
    }

    public static function personalUpdateValidation($data, $slug)
    {

        $rules = [
            'nom' => ['required', 'string', 'max:255'],
            'prenom' => ['sometimes', 'nullable', 'string', 'max:255'],
            'nationalite' => ['sometimes', 'nullable', 'string', 'max:255'],
            'quartier' => ['sometimes', 'nullable', 'string', 'max:255'],
            'code_postal' => ['sometimes', 'nullable', 'string'],
            'ville' => ['required', 'string', 'max:255'],
            'pays' => ['required', 'string', 'max:255'],
            'telephone' => ['required', 'string', 'max:255'],
            'email' => ['sometimes', 'nullable', 'string', 'email', 'max:255'],
            'adresse' => ['sometimes', 'nullable', 'string', 'min:3'],
            'isMedicasure' => ['sometimes', 'nullable', 'string'],
            'isNotice' => ['sometimes', 'nullable', 'string'],
            'slack' => ['sometimes', 'nullable', 'string'],
        ];
        $validation = Validator::make($data, $rules);

        return $validation;
    }

    public static function personalValidation($data, $role = null)
    {
        $rule = [
            'nom' => ['required', 'string', 'max:255'],
            'prenom' => ['sometimes', 'nullable', 'string', 'max:255'],
            'nationalite' => ['sometimes', 'nullable', 'string', 'max:255'],
            'quartier' => ['sometimes', 'nullable', 'string', 'max:255'],
            'code_postal' => ['sometimes', 'nullable', 'string'],
            'ville' => ['required', 'string', 'max:255'],
            'pays' => ['required', 'string', 'max:255'],
            'telephone' => ['required', 'string', 'max:255'],
            'adresse' => ['sometimes', 'nullable', 'string', 'min:3'],
            'isMedicasure' => ['sometimes', 'nullable', 'string'],
            'isNotice' => ['sometimes', 'nullable', 'string'],
            'slack' => ['sometimes', 'nullable', 'string'],
        ];
        //        if(!is_null($role) && $role == "Patient"){
        $rule['email'] = "sometimes|nullable|string|email";
        //        }else{
        //            $rule['email'] = "required|string|email|max:255|unique:users";
        //        }

        $validation = Validator::make($data, $rule);
        return $validation;
    }

    public function logout(Request $request)
    {

        if (Auth::check()) {
            $request->user()->token()->revoke();
            if ($request->time_slug)
                TimeActivite::whereSlug($request->time_slug)->update(['stop' => Carbon::now()->format('H:i')]);
            return response()->json([
                'message' => 'Successfully logged out',
            ]);
        } else {
            return response()->json(['error' => 'api.something_went_wrong'], 500);
        }
    }

    public function reset(Request $request)
    {
        $validation =   Validator::make($request->all(), [
            'token' => 'required',
            'user' => 'required',
            'password' => 'required|confirmed|min:8',
        ]);
        if ($validation->fails()) {
            return \response()->json(['error' => $validation->errors()->getMessages()], 419);
        }

        $user = User::findBySlug($request->user);

        $password = $request->password;
        $users = User::whereEmail($user->email)->get();
        if (count($users) > 1) {
            foreach ($users as $item) {
                if (Hash::check($password, $item->password)) {
                    $usePassword = [];
                    $usePassword['password'][0] = 'Password already used. Please use another password';
                    return \response()->json(['error' => $usePassword], 419);
                }
            }
        }

        $user->password = Hash::make($password);

        $user->setRememberToken(Str::random(60));

        $user->save();

        try {
            $mail = new updateSetting($user);
            $when = now()->addMinutes(1);
            Mail::to($user->email)->later($when, $mail);
        } catch (\Swift_TransportException $transportException) {
            $message = "L'operation à reussi mais le mail n'a pas ete envoye. Verifier votre connexion internet ou contacter l'administrateur";
            return response()->json(["message" => $message]);
        }

        return \response()->json(['user' => $user]);
    }

    public function updatePassword(Request $request)
    {
        $validation =   Validator::make($request->all(), [
            'user' => 'required',
            'password' => 'required|confirmed|min:8',
        ]);
        if ($validation->fails()) {
            return \response()->json(['error' => $validation->errors()->getMessages()], 419);
        }

        $user = User::findBySlug($request->user);

        $password = $request->password;
        $users = User::whereEmail($user->email)->get();
        if (count($users) > 1) {
            foreach ($users as $item) {
                if (Hash::check($password, $item->password)) {
                    $usePassword = [];
                    $usePassword['password'][0] = 'Password already used. Please use another password';
                    return \response()->json(['error' => $usePassword], 419);
                }
            }
        }

        $user->password = Hash::make($password);

        $user->setRememberToken(Str::random(60));

        $user->save();

        try {
            $mail = new updateSetting($user);
            $when = now()->addMinutes(1);
            Mail::to($user->email)->later($when, $mail);
        } catch (\Swift_TransportException $transportException) {
            $message = "L'operation à reussi mais le mail n'a pas ete envoye. Verifier votre connexion internet ou contacter l'administrateur";
            return response()->json(["message" => $message]);
        }

        return \response()->json(['user' => $user]);
    }

    public function signature(Request $request)
    {
        $user  = User::find($request->id);

        if ($request->souscripteur) {
            if (!is_null($request->consentement)) {
                $souscripteur = $user->souscripteur;

                $souscripteur->consentement = $request->consentement;
                $souscripteur->save();
            }
        } else {
            if (!is_null($request->consentement)) {
                $patient = $user->patient;

                $patient->consentement = $request->consentement;
                $patient->restriction = $request->restriction;
                $patient->save();
            }
        }

        if (!is_null($request->signature)) {
            if ($user->getMedia('signature')->count() > 0) {
                $user->clearMediaCollection('signature');
            }
            $user->addMediaFromBase64($request->signature)->usingFileName($user->slug . '.png')->toMediaCollection('signature');
            $user = $user->fresh();
        }
        return response()->json(['message' => "Signature ajouté avec succès", 'signature' => $user->signature]);
    }

    public function consentement($souscripteur_slug, $patient_slug)
    {
        return route('consentement.patient', ['souscripteur_slug' => $souscripteur_slug, 'patient_slug' => $patient_slug]);
    }
}
