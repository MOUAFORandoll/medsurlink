@component('mail::message')
Cher-e Docteur {{strtoupper($rdv->praticien->nom)}},

Vous avez un Rendez-vous planifié avec le Patient **{{strtoupper($rdv->patient->nom)}}**
le **{{\Carbon\Carbon::parse($rdv->date)->format('d/m/Y')}}** à **{{\Carbon\Carbon::parse($rdv->date)->format('H').'h'.\Carbon\Carbon::parse($rdv->date)->format('i')}}**.

Si ce Rendez-vous est modifié Prière de Prévenir directement M./Mme **{{strtoupper($rdv->patient->nom)}}** sur son téléphone **{{strtoupper($rdv->patient->telephone)}}**,
et de mettre à jour le nouveau Rendez-vous sur **<a href="{{ config('app.frontend_url').'/appointments' }}">Medsurkink</a>**

Salutations cordiales.

{{ config('app.name') }}
@endcomponent
