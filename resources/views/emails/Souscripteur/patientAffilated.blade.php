@component('mail::message')
# Medsurlink

Bonjour <strong>{{ucfirst($souscripteur->user->prenom).'  '.strtoupper($souscripteur->user->nom)}}</strong>,<br>
Nous espérons vous trouvez bien portant. Vous avez été désigné comme souscripteur du patient:<br>
Nom: <strong>{{ucfirst($patient->user->prenom).'  '.strtoupper($patient->user->nom)}}</strong><br>
Email: {{$patient->user->email}}

{{ config('app.name') }}
<div class="div-logo-mail">
    <img class="logo-footer" src="https://www.back.medsurlink.com/images/logo.png" alt="Logo-Medicasure">
</div>
@endcomponent
