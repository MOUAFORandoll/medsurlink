@component('mail::message')
# Medsurlink Pharmacien

Bonjour <strong>{{ucfirst($user->prenom).'  '.strtoupper($user->nom)}}</strong>,<br>
Retrouvez ci-dessous <strong>Vos identifiants</strong> pour accéder à votre compte Medsurlink :<br>
Email : <strong> {{$user->email}} </strong><br>
Mot de passe : <strong>{{$password}}</strong><br><br>
NB : Veuillez modifier votre mot de passe à votre premiere connexion en cliquant sur <a href="https://www.medsurlink.com/setting">paramètres</a>

{{ config('app.name') }}

<div class="div-logo-mail">
    <img class="logo-footer" src="https://www.back.medsurlink.com/images/logo.png" alt="Logo-Medicasure">
</div>

<a href="{{ config('app.frontend_url') }}">Medsurlink</a>
@endcomponent
