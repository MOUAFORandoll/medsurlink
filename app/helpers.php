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
        $status = getStatus();
        $auteurable_type = $status->getOriginalContent()['auteurable_type'];
        $auteurable_id = $status->getOriginalContent()['auteurable_id'];
        \App\Http\Controllers\Api\AuteurController::store($auteurable_type,$auteurable_id,$operationable_type,$operationable_id,$action);
    }
}
if (!function_exists('getStatus')){
    function getStatus(){
        $user = \Illuminate\Support\Facades\Auth::user();
        $auteurable_type = $user->getRoleNames()->first();
        $auteurable_id = getStatusId($auteurable_type,$user)->getOriginalContent()['auteurable_id'];
        return response()->json(['auteurable_type'=>$auteurable_type,'auteurable_id'=>$auteurable_id,]);
    }
}

if (!function_exists('getStatusId')){
    function getStatusId($roleName,$user){
        if ($roleName == "Praticien"){
            return response()->json(['auteurable_id'=>$user->praticien->id]);
        }
        elseif ($roleName == "Patient"){
            return response()->json(['auteurable_id'=>$user->patient->id]);
        }
        elseif ($roleName == "Gestionnaire"){
            return response()->json(['auteurable_id'=>$user->gestionnaire->id]);
        }
        elseif ($roleName == "Souscripteur"){
            return response()->json(['auteurable_id'=>$user->souscripteur->id]);
        }
        elseif ($roleName == "Medecin controle"){
            return response()->json(['auteurable_id'=>$user->medecinControle->id]);
        }

        elseif ($roleName == "Admin"){
            return response()->json(['auteurable_id'=>0]);
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


