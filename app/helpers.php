<?php

use Carbon\Carbon;

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

