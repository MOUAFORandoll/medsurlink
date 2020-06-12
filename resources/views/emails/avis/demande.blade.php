@component('mail::message')
# Votre avis médical est requis!

Hello Dr. {{$user->nom}}, nous espérons vous trouver bien portant.

Nous aimerions avoir votre avis au sujet d'un-e patient-e.

**Objet** : {{$avis->objet}}

**Description** : {{$avis->description}}

https://www.medsurlink.com/medical-advice

@endcomponent
