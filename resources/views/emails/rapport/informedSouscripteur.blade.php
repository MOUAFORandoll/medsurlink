@component('mail::message')
{{$souscripteur->sexe=='M' ? 'Cher M.' : 'Chere Mme'}} {{strtoupper($souscripteur->user->nom).'  '.ucfirst($souscripteur->user->prenom)}} ,

Le dossier médical de votre proche {{strtoupper($patient->user->nom).'  '.ucfirst($patient->user->prenom)}} a été mis à jour.

Rendez-vous sur https://www.medsurlink.com/login pour consulter à tout moment ses informations médicales.

N'hésitez pas à prendre contact avec notre service pour si vous des questions à l'adresse medical@medicasure.com

Salutations cordiales.

{{--Signature Medsurlink--}}

<div class="div-logo-mail">
<img class="logo-footer" src="{{asset('/images/logo.png')}}" alt="Logo-Medicasure">
</div>
@endcomponent
