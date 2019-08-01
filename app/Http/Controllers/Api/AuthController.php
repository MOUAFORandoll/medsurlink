<?php

namespace App\Http\Controllers\Api;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
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

        // Then we just add the user to the response before returning it.
        $username = $request->getParsedBody()['username'];
        $user = User::whereEmail($username)->first();
        $user->roles;
        $tokenInfo = collect($tokenInfo);
        $tokenInfo->put('user', $user);
//        $status = getStatus($user);
//        defineAsAuthor($status->getOriginalContent()['auteurable_type'],$status->getOriginalContent()['auteurable_id'],'Connexion');
        return $tokenInfo;
    }
}
