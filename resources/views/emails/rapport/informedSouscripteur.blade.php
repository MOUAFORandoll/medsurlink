@component('mail::message')
# Medsurlink

Hello <strong>{{ucfirst($user->prenom).'  '.strtoupper($user->nom)}}</strong>,<br>
<p>Connectez vous à votre compte Medsurlink pour accéder aux mises à jour des informations médicales de l'un de vos affiliés</p><br>
<a href="{{url(config('app.frontend_url'))}}">Medsurkink</a><br>
{{ config('app.name') }}

<div class="div-logo-mail">
<img class="logo-footer" src="{{asset('/images/logo.png')}}" alt="Logo-Medicasure">
</div>
@endcomponent
