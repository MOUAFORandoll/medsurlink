
@component('mail::message')
{{$sexe == 'M' ? 'Cher M.' : 'Chere Mme'}} {{ $name_souscripteur }} ,

Medicasure a planifié un rendez-vous pour Votre proche {{ $name_patient }} pour:
</br> {{ $motif }} ce 
{{\Carbon\Carbon::parse($date)->format('d/m/Y')}} à {{\Carbon\Carbon::parse($date)->format('H').'h'.\Carbon\Carbon::parse($date)->format('i')}} à {{ $etablissement }}.

Si vous avez des questions ou des préoccupations, N'hésitez pas à  nous le faire savoir en reponse à ce mail

Salutations cordiales.

{{--Signature Medsurlink--}}
{{ config('app.name') }}
<div class="div-logo-mail">
    <img class="logo-footer" src="{{asset('/images/logo.png')}}" alt="Logo-Medicasure">
</div>
@endcomponent
