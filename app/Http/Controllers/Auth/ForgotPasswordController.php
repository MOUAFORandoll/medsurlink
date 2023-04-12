<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Password;
use App\Mail\Password\CodeSend;
use App\Models\Assistante;
use App\Models\Gestionnaire;
use App\Models\MedecinControle;
use App\Models\Patient;
use App\Models\Praticien;
use App\Models\Souscripteur;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use DateTime;
use Illuminate\Support\Facades\Auth;

use Laravel\Passport\Http\Controllers\AccessTokenController;
use App\Models\TimeActivite;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function sendReset_LinkEmail(Request $request)
    {
        $this->validateEmail($request);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $response = $this->broker()->sendResetLink(
            $this->credentials($request)
        );

        return response()->json($response == Password::RESET_LINK_SENT
            ? $this->sendResetLinkResponse($request, $response)
            : $this->sendResetLinkFailedResponse($request, $response));
    }
    public function mobileMail(Request $request)
    {
        $state = $request->input()['state'];
        if ($state == 1) {
            $email = $request->input()['email'];
            $reponse =    $this->sendMailCode($email);

            return response()->json(['message' =>   $reponse ? 'Un code vous a ete envoye par mail' : 'Verifier votre adresse mail et reessayez'],  $reponse ? 200 : 203);
        } else if ($state == 2) {

            $email = $request->input()['email'];
            $code =   $request->input()['code'];
            $reponseVerif =    $this->verifyCode($code, $email);

            return response()->json(
                [
                    'message' =>  !empty($reponseVerif) ? 'Code correct' : 'Code incorrect',
                    'data' => $reponseVerif
                ],
                !empty($reponseVerif)  ? 200 : 203
            );
        } else if ($state == 3) {
            $email = $request->input()['email'];

            $password = $request->input()['password'];
            $compte = $request->input()['compte'];
            $reponseUpdate =    $this->updatePasswordUser($email, $password,            $compte);

            return response()->json(['message' =>   $reponseUpdate ? 'OK' : 'Verifier vos informations et reessayez'],  $reponseUpdate ? 200 : 203);
        } else {
            return response()->json(
                [
                    'message' => 'Une erreur est survenue',
                ],
                203
            );
        }



        # code...
    }
    //ici on envoi le code de reinitialisation par mail
    public function sendMailCode($email)
    {

        $validator = Validator::make(
            ['email' => $email],
            ['email' => 'required|email']
        );

        if ($validator->fails()) {
            return false;
        } else {
            $users = User::whereEmail($email)->get();
            if (count($users) > 0) {
                $code =    $this->generateCode($email);

                try {
                    $mail = new CodeSend($code);

                    Mail::to($email)->send($mail);
                    return true;
                } catch (\Swift_TransportException $transportException) {
                    $message = "L'operation à reussi mais le mail n'a pas ete envoye. Verifier votre connexion internet ou contacter l'administrateur";
                    return response()->json(["message" => $message]);
                }
            } else {
                return false;
            }
        }
    }
    //ici on verifie le code envoye par le user
    /**
     * @param $code represnete le code entre par le user
     * @return $listCompte on lui retourne la liste des comptes lies a ce code || ou l'@ mail

     */
    public function verifyCode($code, $email)
    {

        $exist = false;
        $listCompte = [];
        $users = User::whereEmail($email)->get();

        foreach ($users as $user) {
            if (strval($code) == strval($user->codeR)) {
                $exist = true;
                // if (
                //     $exist == true
                // ) {
                $listCompte =   $this->getCompteUser($email);
                break;
                // } else {
                //     $listCompte = [];
                // }
            }
        }

        return $listCompte;
    }
    /**
     * @param $password represente le mot de passe de l'utilisateur a mettre a jour
     * @param $idCompte represente idCompte dont le mot de passe doit etre mis a jour
     * @return $data  on retourne a l'utilisateur les memes information qui lui sont retourne lors de sa connexion
     */
    public function updatePasswordUser($email, $password, $idCompte)
    {
        $status = false;
        $validator = Validator::make(
            ['password' => $password],
            ['password' =>  'required|string|min:8']
        );

        if ($validator->fails()) {

            $status = false;
            return
                $status;
        } else {
            $user = User::where('id', $idCompte)->first();
            if ($user) {
                // $users = User::whereEmail($email)->get();
                // $exist = $this->validateForPassportPasswordGrant($email, $password);
                // if (!$exist) {
                //ici on recuper le user a partir de l'email et du compte a reinitialiser
                $user->password = Hash::make($password);
                $user->updated_at = new DateTime();
                $user->save();
                $status =
                    true;
                return
                    $status;
                // } else {
                //     $status = false;
                // }
            } else {
                $status = false;
                return
                    $status;
            }
        }
    }

    /**
     * Validate the password of the user for the Passport password grant.
     *
     * @param  string $password
     * @return bool
     */
    public function validateForPassportPasswordGrant($email, $password)
    {
        $users = User::where('email', $email)->get();
        $passwordExist = false;
        foreach ($users as $user) {
            if (Hash::check($password, $user->password)) {
                $passwordExist = true;
                break;
            }
        }
        return $passwordExist;
    }

    public  function getCompteUser($email)
    {
        $listCompte = [];
        $users = User::whereEmail($email)->get();

        foreach ($users as $user) {
            $souscripteur =  Souscripteur::where('user_id', $user->id)->get();

            if (count($souscripteur) > 0) {
                $listCompte[] = ['titre' => 'souscripteur', 'user_id' => $user->id];
            }

            $patient =  Patient::where('user_id', $user->id)->get();
            if (count($patient) > 0) {
                $listCompte[] = ['titre' => 'patient', 'user_id' => $user->id];
            }
            $praticien =  Praticien::where('user_id', $user->id)->get();
            if (count($praticien) > 0) {
                $listCompte[] = ['titre' => 'praticien', 'user_id' => $user->id];
            }
            $medecincontrole =  MedecinControle::where('user_id', $user->id)->get();
            if (count($medecincontrole) > 0) {
                $listCompte[] = ['titre' => 'medecin controle', 'user_id' => $user->id];
            }
            $assistante =  Assistante::where('user_id', $user->id)->get();
            if (count($assistante) > 0) {
                $listCompte[] = ['titre' => 'assistante', 'user_id' => $user->id];
            }
            // $listCompte[]
            //     = $assistante;
        }
        return $listCompte;
    }
    public  function generateCode($email)
    {
        $code = strval(rand(1000, 9999));

        $users = User::whereEmail($email)->get();

        foreach ($users as $user) {
            $user->codeR =  $code;
            $user->updated_at = new DateTime();
            $user->save();
        }
        return $code;
    }


    // public  function generateUserToken( )
    // {
    //   $username='hari.randoll@gmail.com';
    //     $password = '12345678';

    //   // Then we just add the user to the response before returning it.
    //     $user = $this->getUser($username,$password);
    //     // $test=[];
    //     // if($user==new User())
    //     // return "true";
    //     // return $user;
    //     if(!($user==new User())){
    //         // return "ici";
    //         Auth::login($user);
    //         $request = [
    //             'grant_type' => 'password',
    //             'client_id' =>2,
    //             'client_secret' => 'EgDwYss1HthxUbAjbRViO0QaNF82gsJIyCiKXiZr',
    //             'username' => $username,
    //             'password' => $password,

    //         ];
    //         $permissions = $user->roles[0]->permissions->pluck('name');
    //         $user->roles = $user->roles->makeHidden(['created_at', 'updated_at', 'pivot', 'guard_name', 'permissions']);
    //         $user = $user->makeHidden(['created_at', 'updated_at', 'email_verified_at', 'adresse', 'quartier', 'deleted_at']);
    //         $user->unread_notifications = $user->unreadNotifications()->latest()->get();
    //         $user->unread_notifications = $user->unreadNotifications->makeHidden(['updated_at', 'pivot', 'guard_name', 'notifiable_type', 'read_at']);
    //         $user->permissions = $permissions;
    //         $tokenResponse = parent::issueToken($request);
    //         $token = $tokenResponse->getContent();

    //         // $tokenInfo will contain the usual Laravel Passort token response.
    //         $tokenInformation = json_decode($token, true);
    //         $tokenInfo = collect($tokenInformation);
    //         if ($tokenInfo->has('error')){
    //             // return "ici";
    //             return response()->json(['message'=>$tokenInfo->get('message')],401);
    //         }


    //         $time = TimeActivite::create([
    //             'date'=>Carbon::now()->format('Y-m-d'),
    //             'start'=>Carbon::now()->format('H:i')
    //         ]);
    //         $user['time_slug'] = $time->slug;
    //         $user['isEtablissement'] = isComptable();
    //         $tokenInfo->put('token_expires_at',Carbon::parse()->addSeconds($tokenInfo['expires_in']));
    //         // dd($tokenInfo);
    //         $tokenInfo->put('user', $user);
    //         $user_id = $user->id;

    //         $status = getStatus();
    //         if($status == null){
    //             return response()->json(['message'=>"Compte suspendu"],422);
    //         }
    //         defineAsAuthor($status->getOriginalContent()['auteurable_type'],$status->getOriginalContent()['auteurable_id'],'Connexion');
    //         return $tokenInfo;
    //     }
    //     else
    //     return response()->json(['message'=>"The user credentials were incorrect."],401);
    // }
    // public function getUser($username, $password)
    // {
    //     //Verification de l'existence de l'adresse email
    //     $validator = Validator::make(compact('username'), ['username' => ['exists:users,email']]);
    //     if ($validator->fails()) {

    //         //Verification de l'existence du numero de dossier
    //         if (strlen($username) <= 9) {
    //             $numero_dossier = $username;
    //             $dossier = DB::table('dossier_medicals')->where('numero_dossier', '=', $numero_dossier)->first();
    //             if (!is_null($dossier)) {
    //                 $user = User::whereId($dossier->patient_id)->first();
    //                 $user['dossier'] = $dossier->slug;

    //                 return $user;
    //             }
    //             return null;
    //         }
    //         return null;
    //     }

    //     $users = User::where('email', $username)->get();
    //     // return $users;
    //     $authUser = new User();
    //     // if($authUser==new User())
    //     // return "vide";
    //     // return $authUser;
    //     foreach ($users as $user) {
    //         if (Hash::check($password, $user->password)) {

    //             $authUser = $user;
    //             $dossier = DB::table('dossier_medicals')->where('patient_id', '=', $authUser->id)->first();
    //             if (!is_null($dossier)) {
    //                 $user = User::whereId($dossier->patient_id)->first();
    //                 $authUser = $user;
    //                 $authUser['dossier'] = $dossier->slug;
    //             }
    //         }
    //     }
    //     return $authUser;
    // }

}
