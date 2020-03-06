@component('mail::message')
# Medsurlink

Hello <strong>{{ucfirst($user->prenom).'  '.strtoupper($user->nom)}}</strong>,<br>
<p>Vos informations ont été mise à jour avec succès</p><br>

Cliquer <a href="{{ config('app.frontend_url') }}">ici</a> pour plus d'informations<br>

{{ config('app.name') }}

<div class="div-logo-mail">
<img class="logo-footer" src="{{asset('/images/logo.png')}}" alt="Logo-Medicasure">
</div>
@endcomponent
