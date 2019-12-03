<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\PersonnnalException;
use App\Http\Controllers\Traits\PersonnalErrors;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Mail\Password\PasswordGenerated;
use App\Mail\Password\PatientPasswordGenerated;
use App\Models\Souscripteur;
use App\Rules\EmailExistRule;
use App\User;
use http\Env\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Netpok\Database\Support\DeleteRestrictionException;
use PHPUnit\Util\Json;

class UserController extends Controller
{
    use PersonnalErrors;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        foreach ( $users as $user){
            $user->roles;
        }
        return response()->json(['users'=>$users]);
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
        return response()->json(['user'=>$user->getOriginalContent()]);
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
        if(!is_null($validation))
            return $validation;
        $user = User::findBySlug($slug);
        $user->roles;
        return response()->json(['user'=>$user]);
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
    public function update(UserUpdateRequest $request, $slug)
    {
        if ($request->has('error'))
        {
            return  response()->json(['error'=>$request->all()['error']],419);
        }

        $validation = $this->validatedSlug($slug);
        if(!is_null($validation))
            return $validation;

        $user = User::whereSlug($slug)->update($request->validated());

        return response()->json(['user'=>$user]);
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
        if(!is_null($validation))
            return $validation;

        try{
            $user = User::findBySlug($slug);
            $user->delete();
            return response()->json(['user'=>$user]);
        }catch (DeleteRestrictionException $deleteRestrictionException){
            $this->revealError('deletingError',$deleteRestrictionException->getMessage());
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function validatedSlug($slug){
        $validation = Validator::make(compact('slug'),['slug'=>'exists:users,slug']);
        if ($validation->fails()){
            return response()->json($validation->errors(),422);
        }
        return null;
    }

    public static function generatedUser($request,$role = null){

        $validation = self::personalValidation($request->all(),$role);

        if ($validation->fails())
            throw new ValidationException($validation,$validation->errors());

        $password = str_random(10);

        $email = $request->email;

        if (!is_null($role) && $role == "Patient"){
            if(is_null($email)){
               $souscripteur =  Souscripteur::with('user')->where('user_id','=',$request->souscripteur_id)->first();
                $email = $souscripteur->user->email;
            }
        }

        $user = User::create([
            'nom'=>$request->nom,
            'prenom'=>$request->prenom,
            'email'=>$email,
            'nationalite'=>$request->nationalite,
            'quartier'=>$request->quartier,
            'code_postal'=>$request->code_postal,
            'ville'=>$request->ville,
            'pays'=>$request->pays,
            'telephone'=>$request->telephone,
            'adresse'=>$request->adresse,
            'password'=>Hash::make($password)
        ]);

        return response()->json(['user'=>$user,'password'=>$password]);
    }

    public static function sendUserInformationViaMail(User $user,$password){

        $mail = new PasswordGenerated($user,$password);
        Mail::to($user->email)->send($mail);
    }
    public static function sendUserPatientInformationViaMail(User $user,$password){

            $mail = new PatientPasswordGenerated($user,$password);
            Mail::to($user->email)->send($mail);
        }

    public static function updatePersonalInformation($data,$slug){
//        dd($data);
        $validation = self::personalUpdateValidation($data,$slug);

        if ($validation->fails())
            throw new ValidationException($validation,$validation->errors());

        User::whereSlug($slug)->update($data);
        $user = User::findBySlug($slug);
        return response()->json(['user'=>$user]);
    }

    public static function personalUpdateValidation($data,$slug){
        $user = User::findBySlug($slug);
        $rules = [
            'nom' => ['required', 'string', 'max:255'],
            'prenom' => ['sometimes','nullable', 'string', 'max:255'],
            'nationalite' => ['required', 'string', 'max:255'],
            'quartier' => ['sometimes','nullable', 'string', 'max:255'],
            'code_postal' => ['sometimes','nullable', 'integer'],
            'ville' => ['required','string', 'max:255'],
            'pays' => ['required','string', 'max:255'],
            'telephone' => ['required','string', 'max:255'],
//            'email' => ['required', 'string', 'email', 'max:255','unique:users,email,'.$user->id],
            'email' => ['required', 'string', 'email', 'max:255'],
            'adresse' => ['required', 'string','min:3'],
        ];
        $validation = Validator::make($data,$rules);

        return $validation;
    }
    public static function personalValidation($data,$role = null){
        $rule = [
            'nom' => ['required', 'string', 'max:255'],
            'prenom' => ['sometimes','nullable', 'string', 'max:255'],
            'nationalite' => ['required', 'string', 'max:255'],
            'quartier' => ['sometimes','nullable', 'string', 'max:255'],
            'code_postal' => ['sometimes','nullable', 'integer'],
            'ville' => ['required','string', 'max:255'],
            'pays' => ['required','string', 'max:255'],
            'telephone' => ['required','string', 'max:255'],
            'adresse' => ['required', 'string','min:3'],
        ];
//        if(!is_null($role) && $role == "Patient"){
            $rule['email'] = "sometimes|nullable|string|email";
//        }else{
//            $rule['email'] = "required|string|email|max:255|unique:users";
//        }

        $validation = Validator::make($data,$rule);
        return $validation;
    }

    public function logout(Request $request)
    {
        if (Auth::check()) {
            $request->user()->token()->revoke();
            return response()->json([
                'message' => 'Successfully logged out',
            ]);
        }else{
            return response()->json(['error' =>'api.something_went_wrong'], 500);
        }


    }
}
