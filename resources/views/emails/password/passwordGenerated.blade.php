@component('mail::message')
# {{ config('app.name') }}

Bonjour <strong>{{ucfirst($user->prenom).'  '.strtoupper($user->nom)}}</strong>,<br>
Votre paiement a bien été effectué. <br>
Retrouvez ci-dessous <strong>Les identifiants</strong> de votre compte :<br>
Email : <strong> {{$user->email}} </strong><br>
Mot de passe : <strong>{{$password}}</strong><br>
Lien de connexion: <a href="{{ config('app.frontend_url') }}"> Connexion </a> <br><br>
NB : Veuillez modifier votre mot de passe à votre première connexion en cliquant sur <a href="https://www.medsurlink.com/setting">paramètres</a>


<div class="div-logo-mail">
    <img class="logo-footer" src="{{asset('/images/logo.png')}}" alt="Logo-Medicasure">
</div>
@endcomponent
