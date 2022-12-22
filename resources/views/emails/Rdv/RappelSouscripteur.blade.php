@component('mail::message')
{{$souscripteur->sexe=='M' ? 'Cher M.' : 'Chere Mme'}} {{strtoupper($souscripteur->user->nom).'  '.ucfirst($souscripteur->user->prenom)}} ,

Medicasure a planifié un Rendez-vous pour Votre proche {{strtoupper($rdv->patient->nom).'  '.ucfirst($rdv->patient->prenom)}} a un Rendez-vous planifié pour: 
</br> {{$rdv->motifs}} ce 
{{\Carbon\Carbon::parse($rdv->date)->format('d/m/Y')}} à {{\Carbon\Carbon::parse($rdv->date)->format('H').'h'.\Carbon\Carbon::parse($rdv->date)->format('i')}} à {{$rdv->etablissement->name}}.

Si vous avez des questions ou des préoccupations, N'hésitez pas à  nous le faire savoir en reponse à ce mail

Salutations cordiales.

{{--Signature Medsurlink--}}
{{ config('app.name') }}
<div class="div-logo-mail">
    <img class="logo-footer" src="{{asset('/images/logo.png')}}" alt="Logo-Medicasure">
</div>
@endcomponent
