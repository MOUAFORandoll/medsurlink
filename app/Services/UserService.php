<?php

namespace App\Services;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;

class UserService
{

    public function __construct()
    {
    }
    public function index(Request $request)
    {
        $size = $request->size ? $request->size : 10;
        $users = User::latest()->paginate($size);
        return $users;
    }

    public function store(Request $request)
    {

        $users = User::whereEmail($request->email)->get();
      
        if (count($users) > 0) {

            $user
                =   $users->first();

            if (
                $request->typeCompte == 0  && !$user->hasRole('Patient-Alerte')
            ) {
                $user->assignRole('Patient-Alerte');
            }
            if (
                $request->typeCompte == 1  && !$user->hasRole('Directeur')
            ) {
                $user->assignRole('Directeur');
            }
        } else {


            $user = User::create([
                'nom' => $request->nom,
                'prenom' => $request->prenom,
                'telephone' => '0',
                'email' => $request->email,
                'sexe' => $request->sexe,
                'ville' => $request->ville,
                'password' => Hash::make($request->password)
            ]);
            //
            if ($request->typeCompte == 0 || $request->typeCompte == null) {
                $user->assignRole('Patient-Alerte');
            }
            if ($request->typeCompte == 1) {
                $user->assignRole('Directeur');
            }
        }

        return  $user;
    }

    public  function existCompte($email, $type)
    {

        $exist = false;
        $users = User::whereEmail($email)->get();

        foreach ($users as $user) {

            if ($user->hasRole('Patient-Alerte') && $type == 0) {
                $exist = true;
            }
            if ($user->hasRole('Directeur') && $type == 1) {
                $exist = true;
            }
        }
        return $exist;
    }

    public function show($user)
    {

        $user = User::findOrFail($user);
        return $user;
    }


    public function update(Request $request, $user)
    {

        return $user;
    }

    public function destroy($user)
    {

        $user = User::findOrFail($user);
        $user->delete();
        return $user;
    }
}
