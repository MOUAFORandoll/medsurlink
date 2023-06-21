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

        $validator = Validator::make(
            ['email' => $email],
            ['email' => 'required|email']
        );

        if ($validator->fails()) {
            $message = "Veuillez renseigner une adresse mail correcte";

            return response()->json(
                ["message" => $message],
                203
            );
        } else {

            $code =
                $code = strval(rand(1000, 9999));

            try {
                $mail = new RegisterCodeSend($code);

                Mail::to($email)->send($mail);
                return response()->json(["message" => 'Le code vous a ete envoye avec succes', "code" => $code]);
            } catch (\Swift_TransportException $transportException) {
                $message = "L'operation à echoue, le mail n'a pas ete envoye. Verifier votre connexion internet ou contacter l'administrateur";
                return response()->json(
                    ["message" => $message],
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
