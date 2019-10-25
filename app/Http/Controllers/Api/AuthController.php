<?php

namespace App\Http\Controllers\Api;

use App\Models\DossierMedical;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
         $tokenInfo = json_decode($token, true);
        $tokenInfo = collect($tokenInfo);

         if ($tokenInfo->has('error'))
             return response()->json(['message'=>$tokenInfo->get('message')],401);


        // Then we just add the user to the response before returning it.
        $username = $request->getParsedBody()['username'];
        $user = $this->getUser($username);
        $user->roles;
        Auth::setUser($user);
        $tokenInfo->put('user', $user);
        $status = getStatus();
        defineAsAuthor($status->getOriginalContent()['auteurable_type'],$status->getOriginalContent()['auteurable_id'],'Connexion');
        return $tokenInfo;
    }

    public function getUser($username){
        //Verification de l'existence de l'adresse email
        $validator = Validator::make(compact('username'),['username'=>['exists:users,email']]);
        if($validator->fails()){

            //Verification de l'existence du numero de dossier
            if (strlen($username)==8){
                $numero_dossier = $username;
                $dossier = DB::table('dossier_medicals')->where('numero_dossier','=',$numero_dossier)->first();
                if (!is_null($dossier)){
                    $user = User::whereId($dossier->patient_id)->first();
                    return $user;
                }
                return [];
            }
            return [];
        }
        return  User::where('email', $username)->first();
    }
}
