<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

if (!function_exists('evaluateYearOfOld')){
    function evaluateYearOfOld($date_de_naissance){
        $age = Carbon::today()->diffInYears(Carbon::parse($date_de_naissance));
        return $age;
    }
}

if (!function_exists('fullName')){
    function fullName(\Illuminate\Http\Request $request){
        return strtoupper($request->nom).' '.ucfirst($request->prenom);
    }
}
if (!function_exists('validatedId')){
    function validatedId($id,$table){
        $validation = Validator::make(compact('id'),['id'=>'exists:'.$table.',id']);
        if ($validation->fails()){
            return response()->json($validation->errors(),422);
        }
        return null;
    }
}
if (!function_exists('dateOfToday')) {
    function dateOfToday()
    {
        return Carbon::today()->format('Y-m-d');
    }
}
if (!function_exists('defineAsAuthor')){
    function defineAsAuthor($operationable_type,$operationable_id,$action){
        $auteurable_type = getStatus()->getOriginalContent()['auteurable_type'];
        $auteurable_id = getStatus()->getOriginalContent()['auteurable_id'];
        \App\Http\Controllers\Api\AuteurController::store($auteurable_type,$auteurable_id,$operationable_type,$operationable_id,$action);
    }
}
if (!function_exists('getStatus')){
    function getStatus($user = null){
        if (is_null($user)){
            $user = \Illuminate\Support\Facades\Auth::user();
        }
        $auteurable_type = $user->getRoleNames()->first();
        $auteurable_id = getStatusId($auteurable_type)->getOriginalContent()['auteurable_id'];
        return response()->json(['auteurable_type'=>$auteurable_type,'auteurable_id'=>$auteurable_id,]);
    }
}

if (!function_exists('getStatusId')){
    function getStatusId($roleName){
        if ($roleName == "Praticien"){
            $user = \Illuminate\Support\Facades\Auth::user();
            return response()->json(['auteurable_id'=>$user->praticien->id]);
        }
        if ($roleName == "Patient"){
            $user = \Illuminate\Support\Facades\Auth::user();
            return response()->json(['auteurable_id'=>$user->patient->id]);
        }
        if ($roleName == "Gestionnaire"){
            $user = \Illuminate\Support\Facades\Auth::user();
            return response()->json(['auteurable_id'=>$user->gestionnaire->id]);
        }
        if ($roleName == "Souscripteur"){
            $user = \Illuminate\Support\Facades\Auth::user();
            return response()->json(['auteurable_id'=>$user->souscripteur->id]);
        }
        if ($roleName == "Medecin controle"){
            $user = \Illuminate\Support\Facades\Auth::user();
            return response()->json(['auteurable_id'=>$user->medecinControle->id]);
        }
    }
}
if (!function_exists('checkIfIsAuthor')){
    function checkIfIsAuthor($operationable_type,$operationable_id,$action){
        $user = \Illuminate\Support\Facades\Auth::user();
        $nbre  = 0;
        if (!is_null($user->auteurs)){
            $nbre = $user->auteurs->where('action','=',$action)->where('operationable_type','=',$operationable_type)->where('operationable_id','=',$operationable_id)->count();
        }
        if ($nbre>0)
            return response()->json(true);
        return response()->json(false);
    }
}


