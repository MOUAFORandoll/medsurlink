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
if (!function_exists('dateOfToday')){
    function dateOfToday(){
        return Carbon::today()->format('Y-m-d');
    }
}
