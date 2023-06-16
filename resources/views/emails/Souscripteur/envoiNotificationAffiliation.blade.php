@component('mail::message')
# Notification de l'enregistrement d'une affiliation

Une nouvelle affiliation a été ajoutée sur la plateforme

## Infomations du souscripteur

Nom : <b>{{ $souscripteur->user->nom }}</b>

Prénom :<b>{{ $souscripteur->user->prenom }}</b>

Téléphone du souscripteur :<b>{{ $souscripteur->user->telephone}}</b>

## Information sur le type d'affiliation

Affiliation choisie :<b>{{$typeSouscription}}</b>

Les soins seront payés par l'affilié : <b>{{$paye_par_affilie}}</b>


## Informations sur l'affilié(e)

Nom : <b>{{ $patient_nom }}</b>

Prénom : <b>{{ $patient_prenom }}</b>

Numero de téléphone du patient :<b>{{ $patient_telehone }}</b>

Plaintes :
<ul>
    @forelse ($plaintes as $item)
        <li> <b>{{ $item->description }}</b> </li>
    @empty
    @endforelse
</ul>

Niveau d'urgence :<b> {{ $affiliation->niveau_urgence ? $affiliation->niveau_urgence : $niveau_urgence }}</b>


## Informations sur la personne à contacter

Nom : <b>{{ $contact_nom }}</b>

Prénom : <b>{{ $contact_prenom }}</b>

Numero de téléphone de la personne à contacter :<b>{{ $contact_phone }}</b>

{{ config('app.name') }}
<div class="div-logo-mail">
    <img class="logo-footer" src="https://www.back.medsurlink.com/images/logo.png" alt="Logo-Medicasure">
</div>
@endcomponent
