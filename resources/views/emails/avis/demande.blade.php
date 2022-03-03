@component('mail::message')
# <span style="color:#00ada7" >Votre avis médical est requis!</span>

Hello Dr. {{$user->nom}}, nous espérons vous trouver bien portant.

Nous aimerions avoir votre avis au sujet d'un-e patient-e.

**Objet** : {{$avis->objet}}

**Description** : {!! $avis->description !!}

**Niveau d'urgence** : {!! $avis->code_urgence !!}

{{ config('app.name') }} by Medicasure
<div class="div-logo-mail">
    <img class="logo-footer" src="{{asset('/images/logo.png')}}" alt="Logo-Medicasure">
</div>
@endcomponent
