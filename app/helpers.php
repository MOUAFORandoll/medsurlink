<?php

use Carbon\Carbon;

if (!function_exists('evaluateYearOfOld')){
    function evaluateYearOfOld($date_de_naissance){
        $age = Carbon::today()->diffInYears(Carbon::parse($date_de_naissance));
        return $age;
    }
}

if (!function_exists('fullName')){
    function fullName($entite){
        return strtoupper($entite->nom).' '.ucfirst($entite->prenom);
    }
}

