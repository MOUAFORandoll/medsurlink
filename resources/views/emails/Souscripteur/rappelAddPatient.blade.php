@component('mail::message')
# Medsurlink

Hello <strong>{{ucfirst($souscripteur->user->prenom).'  '.strtoupper($souscripteur->user->nom)}}</strong>,<br>
Nous espérons vous trouvez bien portant. Vous devez completer votre souscription en ajoutant vos affiliés:<br>
Merci de vous connecter à <a href="https://www.medsurlink.com/">Medsurlink</a> pour renseigner les informations sur vos affiliés.

{{ config('app.name') }}
<div class="div-logo-mail">
    <img class="logo-footer" src="{{asset('/images/logo.png')}}" alt="Logo-Medicasure">
</div>
@endcomponent
