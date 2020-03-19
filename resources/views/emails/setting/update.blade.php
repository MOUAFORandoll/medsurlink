@component('mail::message')
# Medsurlink

Hello <strong>{{ucfirst($user->prenom).'  '.strtoupper($user->nom)}}</strong>,<br>
<p>Vos informations ont été mise à jour avec succès</p><br>

<<<<<<< HEAD
Cliquer<a href="{{ config('app.frontend_url') }}"> ici </a> pour plus d'informations<br>
=======
<a href="{{ config('app.frontend_url') }}">Cliquer ici pour plus d'informations</a> <br>
>>>>>>> 6c9aefb4cb5d0e748ceb268d52ea533c66a296ac

{{ config('app.name') }}

<div class="div-logo-mail">
<img class="logo-footer" src="{{asset('/images/logo.png')}}" alt="Logo-Medicasure">
</div>
@endcomponent
