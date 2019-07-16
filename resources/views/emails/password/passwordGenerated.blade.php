@component('mail::message')
# Medicalink

Hello <strong>{{$user->name}}</strong>,<br>
Nous espérons vous trouvez bien portant. Voici <strong>vos identifiants</strong> pour accéder à votre compte Medicalink:<br>
Email : <strong>{{$user->email}}</strong><br>
Mot de passe : <strong>{{$user->password}}</strong><br>
<strong><i>NB :</i> Veuillez modifier votre mot de passe à votre premiere connexion</strong>

Thanks,<br>
{{ config('app.name') }}
@endcomponent
