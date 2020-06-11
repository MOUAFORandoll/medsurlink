@component('mail::message')
# Mail de demande d'avis

Hello Dr. {{$user->nom}}, nous espérons vous trouvez bien portant.

Nous aimerions avoir votre avis au sujet d'un de nos patients.

Objet : {{$avis->objet}}

Description : {{$avis->description}}

{{$avis->creer_lien == '1' ?'NUMERO DE DOSSIER : '. $avis->dossier->numero_dossier :''}}

@endcomponent
