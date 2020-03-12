@component('mail::message')
# Medsurlink

Bonjour <strong>{{ucfirst($user->prenom).'  '.strtoupper($user->nom)}}</strong>,<br>
Nous espérons vous trouver bien portant. Voici <strong>vos identifiants</strong> pour accéder à votre compte Medicalink :<br>
Email : <strong> {{$user->email}} </strong><br>
Mot de passe : <strong>{{$password}}</strong><br><br>
NB : Veuillez modifier votre mot de passe à votre premiere connexion en cliquant sur <a href="https://www.medsurlink.com/login">mot de passe oublié</a>

{{ config('app.name') }}

<div class="div-logo-mail">
    <img class="logo-footer" src="{{asset('/images/logo.png')}}" alt="Logo-Medicasure">
</div>

<a href="{{ config('app.frontend_url') }}">Medsurlink</a>
@endcomponent
