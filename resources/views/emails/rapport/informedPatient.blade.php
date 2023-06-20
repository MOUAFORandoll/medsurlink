@component('mail::message')
# Medsurlink

Hello <strong>{{ucfirst($user->prenom).'  '.strtoupper($user->nom)}}</strong>,<br>
<p>Connectez vous à votre compte Medsurlink pour accéder aux mises à jour de vos informations médicales </p><br>
<a href="{{url(config('app.frontend_url'))}}">Medsurkink</a><br>
{{ config('app.name') }}

<div class="div-logo-mail">
<img class="logo-footer" src="https://www.back.medsurlink.com/images/logo.png" alt="Logo-Medicasure">
</div>
@endcomponent
