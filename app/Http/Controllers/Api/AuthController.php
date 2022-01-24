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
            $user->roles;
            Auth::login($user);

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

        $tokenResponse = parent::issueToken($request);
        $token = $tokenResponse->getContent();//json_decode($res->getBody()->getContents());
        dd($tokenResponse);
        // $tokenInfo will contain the usual Laravel Passort token response.
        $tokenInformation = json_decode($token, true);
        $tokenInfo = collect($tokenInformation);
        //dd($request);
        if ($tokenInfo->has('error'))
            return response()->json(['message'=>$tokenInfo->get('message')],401);

        // Then we just add the user to the response before returning it.
        $username = $request->getParsedBody()['username'];
        $password = $request->getParsedBody()['password'];

        //$user = $this->getUser($username,$password);
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
                        return [];
                    }
                    return [];
                }

                $users = User::where('email', $username)->get();
                $authUser = new User();

                foreach ($users as $user){
                    if($password == $user->password){
                        $authUser = $user;
                        $dossier = DB::table('dossier_medicals')->where('patient_id','=',$authUser->id)->first();
                        if(!is_null($dossier)){
                            $user = User::whereId($dossier->patient_id)->first();
                            $authUser = $user;
                            $authUser['dossier'] = $dossier->slug;
                        }
                    }
                }
                $user = $authUser;
        $user->roles;
        Auth::login($user);
        $time = TimeActivite::create([
            'date'=>Carbon::now()->format('Y-m-d'),
            'start'=>Carbon::now()->format('H:i')
        ]);
        $user['time_slug'] = $time->slug;
        $user['isEtablissement'] = isComptable();
        $tokenInfo->put('token_expires_at',Carbon::parse()->addSeconds($tokenInfo['expires_in']));
        $tokenInfo->put('user', $user);
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
}
