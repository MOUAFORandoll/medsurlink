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
    public function auth(ServerRequestInterface $request)
    {

        $tokenResponse = parent::issueToken($request);
        $token = $tokenResponse->getContent();

        // $tokenInfo will contain the usual Laravel Passort token response.
        $tokenInformation = json_decode($token, true);
        $tokenInfo = collect($tokenInformation);
        if ($tokenInfo->has('error'))
            return response()->json(['message'=>$tokenInfo->get('message')],401);

        // Then we just add the user to the response before returning it.
        $username = $request->getParsedBody()['username'];
        $password = $request->getParsedBody()['password'];
        $user = $this->getUser($username,$password);
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
                return [];
            }
            return [];
        }

        $users = User::where('email', $username)->get();
        $authUser = new User();
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
