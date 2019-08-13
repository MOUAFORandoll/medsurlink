@component('mail::message')
# Medicalink

Hello <strong>{{ucfirst($user->prenom).'  '.strtoupper($user->nom)}}</strong>,<br>
Nous espérons vous trouvez bien portant. Voici <strong>vos identifiants</strong> pour accéder à votre compte Medicalink:<br>
Email : <strong> {{$user->email}} </strong><br>
Mot de passe : <strong>{{$password}}</strong><br><br>
<strong><i>NB :</i> Veuillez modifier votre mot de passe à votre premiere connexion</strong>

Thanks,<br>
{{ config('app.name') }}
<div class="div-logo-mail">
    <img class="logo-footer" src="{{asset('/images/logo.png')}}" alt="Logo-Medicasure">
</div>
@endcomponent
