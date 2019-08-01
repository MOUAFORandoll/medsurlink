<?php

namespace App\Http\Controllers\Api;

use App\Models\Auteur;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuteurController extends Controller
{

    public static function store($auteurable_type,$auteurable_id,$operationable_type,$operationable_id,$action){

        Auteur::create([
            'user_id'=>Auth::id(),
            "auteurable_type"=>$auteurable_type,
            "auteurable_id"=>$auteurable_id,
            "operationable_type"=>$operationable_type,
            "operationable_id"=>$operationable_id,
            "action"=>$action,
        ]);
    }
}
