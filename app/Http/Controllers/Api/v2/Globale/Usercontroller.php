<?php

namespace App\Http\Controllers\Api\v2\Globale;

use App\Mail\RegisterCodeSend;
use Illuminate\Http\Request;
use App\Services\UserService;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;

class Usercontroller extends Controller
{
    private $userService;

    /**
     * class UserController extends Controller
     *
     * @param \App\Services\UserService $user
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @return mixed
     */
    public function index(Request $request)
    {
        return $this->successResponse($this->userService->index($request));
    }

    /**
     * @param $user
     *
     * @return mixed
     */
    public function show($user)
    {
        return $this->successResponse($this->userService->show($user));
    }
    //ici on envoi le code de reinitialisation par mail
    public function sendMailStore(Request $request)
    {
        $email = $request->input()['email'];
        $typeCompte = $request->input()['typeCompte'];

        $exitCompte = $this->userService->existCompte($email, $typeCompte);
        if ($exitCompte) {

            return $this->successResponse([
                'message_fr' =>  'Vous avez déjà un compte a cette adresse mail, choisissez-en une autre',
                'message_en' =>    'You already have an account at this email address, choose another one',
            ], 203);
        }

        $validator = Validator::make(
            ['email' => $email],
            ['email' => 'required|email']
        );

        if ($validator->fails()) {
            $message_fr = "Veuillez renseigner une adresse mail correcte";
            $message_en = "Please enter a correct email address";

            return response()->json(
                ["message_en" => $message_en, "message_fr" => $message_fr],
                203
            );
        } else {

            $code =
                $code = strval(rand(1000, 9999));

            try {
                $mail = new RegisterCodeSend($code);

                Mail::to($email)->send($mail);
                return response()->json(["message_fr" => 'Le code vous a été envoyé avec succes', "message_en" => 'The code has been successfully sent to you', "code" => $code]);
            } catch (\Swift_TransportException $transportException) {
                $message_fr = "L'opération à echoue, le mail n'a pas été envoyé. Vérifier votre connexion internet ou contacter l'administrateur";
                $message_en = "The operation failed, the email was not sent. Check your internet connection or contact the administrator";
                return response()->json(
                    ["message_fr" => $message_fr, "message_en" => $message_en],
                    203
                );
            }
        }
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     */
    public function store(Request $request)
    {
        $this->validate($request, $this->validations());
        return $this->successResponse($this->userService->store($request));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param                          $user
     *
     * @return mixed
     */
    public function update(Request $request, $user)
    {
        $this->validate($request, $this->validations(true));
        return $this->successResponse($this->userService->update($request, $user));
    }

    /**
     * fonction de validation des formulaires
     */
    public function validations($is_update = null)
    {
        if ($is_update) {
            $rules = [
                'nom' => 'required',
                'prenom' => 'required',
                'email' => 'required|email|unique:users',
                //'email' => 'required|email:rfc,dns|unique:users',
                'sexe' => 'required',
                'ville' => 'required',
                'password' => 'required|confirmed'
            ];
        } else {
            $rules = [
                'nom' => 'required',
                'prenom' => 'required',
                'email' => 'required|email|unique:users',
                //'email' => 'required|email:rfc,dns|unique:users',
                'sexe' => 'required',
                'ville' => 'required',
                'password' => 'required|confirmed',
                'password_confirmation' => 'required',
            ];
        }
        return $rules;
    }
}
