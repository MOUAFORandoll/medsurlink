@component('mail::message')
# Medsurlink

Hello <strong>{{ucfirst($user->prenom).'  '.strtoupper($user->nom)}}</strong>,<br>
Connectez vous à votre compte Medsurlink pour accéder aux mises à jour des informations médicales de l'un de vos affiliés
<a href="{{url(config('app.frontend_url'))}}">Medsurkink</a>
{{ config('app.name') }}

<img class="logo-footer" src="{{asset('/images/logo.png')}}" alt="Logo-Medicasure">
@endcomponent
