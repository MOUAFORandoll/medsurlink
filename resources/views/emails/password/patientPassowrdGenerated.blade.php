@component('mail::message')
# Medsurlink

Bonjour <strong>{{ucfirst($user->prenom).'  '.strtoupper($user->nom)}}</strong>,<br>
Nous espérons vous trouver bien portant. Voici <strong>vos identifiants</strong> pour accéder à votre compte Medsurlink:<br>
Email : <strong> {{$user->email}} </strong><br>
Numero de dossier : <strong>{{$user->patient->dossier->numero_dossier}}</strong><br>
Mot de passe : <strong>{{$password}}</strong><br><br>
<strong><i>NB :</i> Veuillez modifier votre mot de passe à votre premiere connexion</strong>

{{ config('app.name') }}

<div class="div-logo-mail">
<img class="logo-footer" src="{{asset('/images/logo.png')}}" alt="Logo-Medicasure">
</div>
@endcomponent
