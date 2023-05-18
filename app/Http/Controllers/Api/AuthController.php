<?php

namespace App\Http\Controllers\Api;

use App\Models\DossierMedical;
use App\Models\TimeActivite;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Laravel\Passport\Http\Controllers\AccessTokenController;
use Psr\Http\Message\ServerRequestInterface;

class AuthController extends AccessTokenController
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
    public function auth(ServerRequestInterface $request)
    {

        // Then we just add the user to the response before returning it.
        $username = $request->getParsedBody()['username'];
        $password = $request->getParsedBody()['password'];
        $user = $this->getUser($username,$password);
        // $test=[];
        // if($user==new User())
        // return "true";
        // return $user;
        if(!($user==new User())){
            // return "ici";
            Auth::login($user);
            $permissions = $user->roles[0]->permissions->pluck('name');
            $user->roles = $user->roles->makeHidden(['created_at', 'updated_at', 'pivot', 'guard_name', 'permissions']);
            $user = $user->makeHidden(['created_at', 'updated_at', 'email_verified_at', 'adresse', 'quartier', 'deleted_at']);
            $user->unread_notifications = $user->unreadNotifications()->latest()->get();
            $user->unread_notifications = $user->unreadNotifications->makeHidden(['updated_at', 'pivot', 'guard_name', 'notifiable_type', 'read_at']);
            $user->permissions = $permissions;
            $tokenResponse = parent::issueToken($request);
            $token = $tokenResponse->getContent();

            // $tokenInfo will contain the usual Laravel Passort token response.
            $tokenInformation = json_decode($token, true);
            $tokenInfo = collect($tokenInformation);
            if ($tokenInfo->has('error')){
                // return "ici";
                return response()->json(['message'=>$tokenInfo->get('message')],401);
            }


            $time = TimeActivite::create([
                'date'=>Carbon::now()->format('Y-m-d'),
                'start'=>Carbon::now()->format('H:i')
            ]);
            $user['time_slug'] = $time->slug;
            $user['isEtablissement'] = isComptable();
            $tokenInfo->put('token_expires_at',Carbon::parse()->addSeconds($tokenInfo['expires_in']));
            // dd($tokenInfo);
            $tokenInfo->put('user', $user);
            $user_id = $user->id;

            $status = getStatus();
            if($status == null){
                return response()->json(['message'=>"Compte suspendu"],422);
            }
            defineAsAuthor($status->getOriginalContent()['auteurable_type'],$status->getOriginalContent()['auteurable_id'],'Connexion');
            return $tokenInfo;
        }
        else
        return response()->json(['message'=>"The user credentials were incorrect."],401);

    }
    public function authAfterRedirect(ServerRequestInterface $request)
    {
        $user = User::where('slug', $request->getParsedBody()['password'])->first();

        //$tokenResponse = parent::issueToken($request);
        $token = $user->createToken($request->getParsedBody()['client_secret'])->accessToken;

        // $tokenInfo will contain the usual Laravel Passort token response.
        $tokenInfo = collect();

        $user->roles;
        Auth::login($user);
        $time = TimeActivite::create([
            'date'=>Carbon::now()->format('Y-m-d'),
            'start'=>Carbon::now()->format('H:i')
        ]);
        $user['time_slug'] = $time->slug;
        $user['isEtablissement'] = isComptable();
        $permissions = $user->roles[0]->permissions->pluck('name');
        $user->roles = $user->roles->makeHidden(['created_at', 'updated_at', 'pivot', 'guard_name', 'permissions']);
        $user = $user->makeHidden(['created_at', 'updated_at', 'email_verified_at', 'adresse', 'quartier', 'deleted_at']);
        $user->unread_notifications = $user->unreadNotifications()->latest()->get();
        $user->unread_notifications = $user->unreadNotifications->makeHidden(['updated_at', 'pivot', 'guard_name', 'notifiable_type', 'read_at']);
        $user->permissions = $permissions;
        $tokenInfo->put('token_expires_at', Carbon::parse()->addSeconds(3600));
        $tokenInfo->put('user', $user);
        $tokenInfo->put('access_token', $token);
        $status = getStatus();
        defineAsAuthor($status->getOriginalContent()['auteurable_type'],$status->getOriginalContent()['auteurable_id'],'Connexion');
        return $tokenInfo;
    }
    public function getUser($username,$password){
        //Verification de l'existence de l'adresse email
        $validator = Validator::make(compact('username'),['username'=>['exists:users,email']]);
        if($validator->fails()){

            //Verification de l'existence du numero de dossier
            if (strlen($username)<=9){
                $numero_dossier = $username;
                $dossier = DB::table('dossier_medicals')->where('numero_dossier','=',$numero_dossier)->first();
                if (!is_null($dossier)){
                    $user = User::whereId($dossier->patient_id)->first();
                    $user['dossier'] = $dossier->slug;

                    return $user;
                }
                return null;
            }
            return null;
        }

        $users = User::where('email', $username)->get();
        // return $users;
        $authUser = new User();
        // if($authUser==new User())
        // return "vide";
        // return $authUser;
        foreach ($users as $user){
            if(Hash::check($password,$user->password)){

                $authUser = $user;
                $dossier = DB::table('dossier_medicals')->where('patient_id','=',$authUser->id)->first();
                if(!is_null($dossier)){
                    $user = User::whereId($dossier->patient_id)->first();
                    $authUser = $user;
                    $authUser['dossier'] = $dossier->slug;
                }
            }
        }
        return $authUser;
    }

    public function userDetails(Request $request){

        $user = $request->user();
        $user->roles;
        $time = TimeActivite::create([
            'date'=>Carbon::now()->format('Y-m-d'),
            'start'=>Carbon::now()->format('H:i')
        ]);
        $user['time_slug'] = $time->slug;
        $user['isEtablissement'] = isComptable();

        return response()->json(['user'=>$user]);
    }

    public function refresh(Request $request){
        $user = auth()->user();
        $access_token =  $user->createToken($request->client_secret);
        return ['access_token' => $access_token->accessToken, 'refresh_token' => $access_token->refreshToken];
    }

    public function me(){
        $user = auth()->user();
        $permissions = $user->roles[0]->permissions->pluck('name');
        $user->roles = $user->roles->makeHidden(['created_at', 'updated_at', 'pivot', 'guard_name', 'permissions']);
        $user = $user->makeHidden(['created_at', 'updated_at', 'email_verified_at', 'adresse', 'quartier', 'deleted_at']);
        $user->unread_notifications = $user->unreadNotifications()->latest()->get();
        $user->unread_notifications = $user->unreadNotifications->makeHidden(['updated_at', 'pivot', 'guard_name', 'notifiable_type', 'read_at']);
        $user->permissions = $permissions;
        $time = TimeActivite::where('user_id',$user->id)->get()->last();
        $user->time_slug = $time->slug;
        return $user;
    }
}
