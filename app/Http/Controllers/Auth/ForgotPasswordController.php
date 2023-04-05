<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\Password\CodeSend;
use App\Models\Assistante;
use App\Models\Comptable;
use App\Models\Gestionnaire;
use App\Models\MedecinControle;
use App\Models\Partenaire;
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

            return response()->json(['message' =>   $reponseUpdate ? 'OK' : 'Verifier le code et reessayez'],  $reponseUpdate ? 200 : 203);
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
            if ($code == $user->codeR) {
                $exist = true;
            }
        }
        if (
            $exist == true
        ) {
            $listCompte =   $this->getCompteUser($email);
        } else {
            $listCompte = [];
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
            ['password' =>  'required|string|size:8']
        );

        if ($validator->fails()) {

            $status = false;
        } else {
            $user = User::where('id', $idCompte)->first();
            if ($user) {
                $users = User::whereEmail($email)->get();

                foreach ($users as $item) {
                    if (Hash::check($password, $item->password)) {
                        $usePassword = [];
                        $usePassword['password'][0] = 'Password already used. Please use another password';

                        $status = false;
                        return \response()->json(['error' => $usePassword], 419);
                    }
                }
                //ici on recuper le user a partir de l'email et du compte a reinitialiser
                $user->password = Hash::make($password);
                $user->updated_at = new DateTime();
                $user->save();
                $status =
                    true;
                // data ici doit contenir les memes infos retournes lors du login

            } else {
                $status = false;
            }
        }
        return
            $status;
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


            // $gestionnaire =  Gestionnaire::where('user_id', $user->id)->get();
            // if ($gestionnaire) {
            //     $listCompte[] = ['titre' => 'gestionnaire', 'user_id' => $user->id];
            // }

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
}
