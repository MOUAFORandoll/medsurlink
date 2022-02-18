@component('mail::message')
# Notification de l'enregistrement d'une affiliation

Une nouvelle affiliation a été saisi sur la plateforme de medicasure

## Infomation du souscripteur

Nom : <b>{{ auth()->user()->nom }}</b>

Prénom :<b>{{ auth()->user()->prenom }}</b>

Téléphone du souscripteur :<b>{{auth()->user()->telephone}}</b>

## Information sur le type d'affiliation

Affiliation choisie :<b>{{$typeSouscription}}</b>

Les soins seront payés par l'affilié : <b>{{$paye_par_affilie}}</b>


## Information sur l'affilié(e)

Nom : <b>{{ $patient_nom }}</b>

Prénom : <b>{{ $patient_prenom }}</b>

Numero de téléphone du patient :<b>{{ $patient_telehone }}</b>

Plainte :<b>{{ $plainte }}</b>

Niveau d'urgence :<b>{{ $urgence }}</b>


## Information sur la personne à contacter

Nom : <b>{{ $contact_nom }}</b>

Prénom : <b>{{ $contact_prenom }}</b>

Numero de téléphone de la personne à contacter :<b>{{ $contact_phone }}</b>

Consulter avec l'un de ces liens


{{ config('app.name') }}
<div class="div-logo-mail">
    <img class="logo-footer" src="{{asset('/images/logo.png')}}" alt="Logo-Medicasure">
</div>
@endcomponent
