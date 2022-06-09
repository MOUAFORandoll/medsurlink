@component('mail::message')
# <span style="color:#00ada7" >Votre avis médical est requis!</span>

Bonjour {{$user->praticien->civilite }} {{$user->nom}} {{$user->prenom ? $user->prenom : ''}}, nous espérons vous trouver bien portant.

Nous aimerions avoir votre avis au sujet du patient <strong> {{$avis->dossier->patient->user->nom }} {{$avis->dossier->patient->user->prenom }} <strong>

**Objet** : {{$avis->objet}}

**Description** : {!! $avis->description !!}

**Niveau d'urgence** : {!! $avis->code_urgence !!}

Lien de connexion: <a href="{{ config('app.frontend_url') }}"> Connexion </a> <br><br>

{{ config('app.name') }}
<div class="div-logo-mail">
    <img class="logo-footer" src="{{asset('/images/logo.png')}}" alt="Logo-Medicasure">
</div>
@endcomponent