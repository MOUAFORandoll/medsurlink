@component('mail::message')
# Medsurlink

Hello <strong>{{ucfirst($user->prenom).'  '.strtoupper($user->nom)}}</strong>,
Connectez vous à votre compte Medsurlink pour accéder aux mises à jour de vos informations médicales
<a href="{{url(config('app.frontend_url'))}}">Medsurkink</a><br>
{{ config('app.name') }}

<img class="logo-footer" src="{{asset('/images/logo.png')}}" alt="Logo-Medicasure">
@endcomponent
