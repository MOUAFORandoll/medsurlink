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

        $user = User::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'sexe' => $request->sexe,
            'ville' => $request->ville,
            'password' => Hash::make($request->password)
        ]);
        //
        // if ($request->typeCompte == 0 || $request->typeCompte == null) {
            $user->assignRole('Patient-Alerte');
        // }
        // if ($request->typeCompte == 1) {
        //     $user->assignRole('Directeur');
        // }



        return $user;
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
