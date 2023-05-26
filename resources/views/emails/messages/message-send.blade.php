<?php

    $url_global = "";
        $env = strtolower(config('app.env'));
        if ($env == 'local')
            $url_global = config('app.url_loccale');
        else if ($env == 'staging')
            $url_global = config('app.url_stagging');
        else
            $url_global = config('app.url_prod');
    // $url_global = $url_global."/alertes?uuid=".$alerte->uuid
?>
@component('mail::message')
# <span style="color:#00ada7" >Nouveau Message!</span>



{{-- {{$user->nom}} {{$user->prenom ? $user->prenom : ''}}, nous espérons vous trouver bien portant. --}}

{{-- Nous aimerions avoir votre avis au sujet du patient <strong> {{$avis->dossier->patient->user->nom }} {{$avis->dossier->patient->user->prenom }} <strong> --}}

**Objet** : {{$subject}}

**Description** : {!! $messageBody !!}


{{ config('app.name') }}
<div class="div-logo-mail">
    <img class="logo-footer" src="{{asset('/images/logo.png')}}" alt="Logo-Medicasure">
</div>
@endcomponent