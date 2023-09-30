<?php

namespace App\Http\Controllers\Api;

use App\Models\DossierMedical;
use App\Models\TimeActivite;
use App\User;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Mail\Password\OTPCodeSend;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Laravel\Passport\Http\Controllers\AccessTokenController;
use Psr\Http\Message\ServerRequestInterface;

class AuthOTPController extends AccessTokenController
{
    /**
     * @OA\Post(
     ** path="/login",
     *   tags={"Login"},
     *   summary="Login",
     *   operationId="login",
     *
     *   @OA\Parameter(
     *      name="email",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *   @OA\Parameter(
     *      name="password",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *          type="string"
     *      )
     *   ),
     *   @OA\Response(
     *      response=200,
     *       description="Success",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   ),
     *   @OA\Response(
     *      response=401,
     *       description="Unauthenticated"
     *   ),
     *   @OA\Response(
     *      response=400,
     *      description="Bad Request"
     *   ),
     *   @OA\Response(
     *      response=404,
     *      description="not found"
     *   ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *)
     **/
    /**
     * login api
     *
     * @return \Illuminate\Http\Response
     */
    public function authOTP(Request $request)
    {

        $validator = Validator::make(
            ['email' => $request->input()['email']],
            ['email' => 'required|email'],
            ['type' => $request->input()['type']],
            ['type' => 'required']
        );
        if ($validator->fails()) {
            return response()->json([

                'message_fr' =>  'Vérifier votre adresse mail et reéssayez',
                'message_en' =>   'Verify your email address and re-enter'
            ],  203);
        } else {
            // Then we just add the user to the response before returning it.
            $email = $request->input()['email'];
            $type  = $request->input()['type'];
            $code = strval(rand(10000, 99999));
            $userAccount = null;
            $users = User::whereEmail($email)->get();
            if (count($users) == 0) {
                return response()->json([

                    'message_fr' =>  'Vérifier votre adresse mail et reéssayez',
                    'message_en' =>   'Verify your email address and re-enter'
                ],  203);
            }

            $experience = $type
                == 0 ? 'Alerte' : 'Etablissement';
            $experience_en = $type == 0 ? 'Alert' : 'Estasblishments';

            foreach ($users as $user) {
                if ($type == 0) {
                    if ($user->hasRole('Patient-Alerte')) {
                        $userAccount = $user;
                        break;
                    }
                }
                if ($type == 1) {
                    if ($user->hasRole('Directeur')) {
                        $userAccount = $user;
                        break;
                    }
                }
            }
            if ($userAccount == null) {
                return response()->json([

                    'message_fr' =>  'Aucun compte trouve pour cette experience ' . $experience . ' Vérifier votre adresse mail et reéssayez',
                    'message_en' =>  'No accounts found for this experience ' . $experience_en . 'Verify your email address and re-enter'
                ],  203);
            }
            try {
                $mail = new OTPCodeSend($code);
                Mail::to($email)->send($mail);
                $userAccount->codeOTP =  $code;
                $userAccount->updated_at = new DateTime();
                $userAccount->save();
                return response()->json([
                    'message_fr' =>   'Un code vous a été envoyé par mail',
                    'message_en' =>   'A code has been sent to you by email'
                ],   200);
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

    public function test()
    {

        $email =
            'hari.randoll@gmail.com';

        $mail = new OTPCodeSend('0000');
        Mail::to($email)->send($mail);

        return response()->json(['status' => 'ok']);
    }

    public function verifyOTPCode(Request $request)
    {

        $validator = Validator::make(
            ['email' => $request->input()['email']],
            ['email' => 'required|email'],
            ['codeOTP' => $request->input()['codeOTP']],
            ['codeOTP' => 'required']
        );
        if ($validator->fails()) {
            return response()->json([
                'message_fr' => 'Vérifier votre adresse mail et reéssayez',
                'message_en' => 'Verify your email address and re-enter'
            ], 203);
        } else {
            $user = null;

            // Then we just add the user to the response before returning it.
            $email      = $request->input()['email'];
            $codeOTP    = $request->input()['codeOTP'];

            $users      = User::whereEmail($email)->get();

            foreach ($users as $usera) {
                if (strval($codeOTP) == strval($usera->codeOTP)) {

                    $user = $usera;
                    break;
                }
            }
            if ($user == null) {
                return response()->json([

                    'message_fr' =>  'Vérifier votre adresse mail et reéssayez',
                    'message_en' =>   'Verify your email address and re-enter'
                ],  203);
            }
            // $users = User::where('email', $username)->get();

            Auth::login($user);

            $permissions = $user->roles->flatMap(function ($role) {
                return $role->permissions;
            })->merge($user->all_permissions)->unique('id');

            $user->codeOTP =  null;
            $user->save();
            // $permissionName = ($permissions->pluck('name'));
            // $user->all_permissions = $user->all_permissions->makeHidden(['created_at', 'updated_at', 'pivot', 'guard_name']);
            $user->roles = $user->roles->makeHidden(['created_at', 'updated_at', 'pivot', 'guard_name', 'permissions']);
            $user = $user->makeHidden(['created_at', 'updated_at', 'email_verified_at', 'adresse', 'quartier', 'deleted_at', 'all_permissions']);
            $user->unread_notifications = $user->unreadNotifications()->latest()->get();
            $user->unread_notifications = $user->unreadNotifications->makeHidden(['updated_at', 'pivot', 'guard_name', 'notifiable_type', 'read_at']);
            $user['permissions'] = $permissions->pluck('name');


            // $usere = Auth::user();
            // $token = $usere->createToken('MonRefreshToken');
            // // $tokenResponse = parent::issueToken($request);
            // // $token = $tokenResponse->getContent();
            // return response()->json(['message' => $token], 422);

            $token =  $user->createToken("EgDwYss1HthxUbAjbRViO0QaNF82gsJIyCiKXiZr")->accessToken;

            // $tokenResponse = parent::issueToken($request); 


            // $tokenInfo will contain the usual Laravel Passort token response.

            $tokenInfo = collect();


            $user->roles;
            Auth::login($user);
            $time = TimeActivite::create([
                'date' => Carbon::now()->format('Y-m-d'),
                'start' => Carbon::now()->format('H:i')
            ]);
            $user['time_slug'] = $time->slug;
            $user['isEtablissement'] = isComptable();
            $permissions = $user->roles->flatMap(function ($role) {
                return $role->permissions;
            })->merge($user->all_permissions)->unique('id');

            $user->roles = $user->roles->makeHidden(['created_at', 'updated_at', 'pivot', 'guard_name', 'permissions']);
            $user = $user->makeHidden(['created_at', 'updated_at', 'email_verified_at', 'adresse', 'quartier', 'deleted_at', 'all_permissions']);
            $user->unread_notifications = $user->unreadNotifications()->latest()->get();
            $user->unread_notifications = $user->unreadNotifications->makeHidden(['updated_at', 'pivot', 'guard_name', 'notifiable_type', 'read_at']);
            $user['permissions'] = $permissions->pluck('name');
            // $tokenInfo->put('token_expires_at', Carbon::parse()->addSeconds(3600));
            $tokenInfo->put('token_type', "Bearer");
            $tokenInfo->put('expires_in', 172800);
            $tokenInfo->put('access_token', $token);
            $tokenInfo->put('token_expires_at', Carbon::parse()->addSeconds(86400));
            $tokenInfo->put('user', $user);
            $status = getStatus();
            defineAsAuthor($status->getOriginalContent()['auteurable_type'], $status->getOriginalContent()['auteurable_id'], 'Connexion');
            return $tokenInfo;
        }
    }
}

/**
 * */
