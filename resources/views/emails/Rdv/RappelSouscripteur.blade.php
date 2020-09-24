@component('mail::message')
{{$souscripteur->sexe=='M' ? 'Cher M.' : 'Chere Mme'}} {{strtoupper($souscripteur->user->nom).'  '.ucfirst($souscripteur->user->prenom)}} ,

Votre proche {{strtoupper($rdv->patient->nom).'  '.ucfirst($rdv->patient->prenom)}} a un Rendez-vous planifié pour son suivi médical le
{{\Carbon\Carbon::parse($rdv->date)->format('d/m/Y')}} à {{\Carbon\Carbon::parse($rdv->date)->format('H').'h'.\Carbon\Carbon::parse($rdv->date)->format('i')}}.

N'hésitez pas à prendre contact avec notre service pour si vous des questions à l'adresse medical@medicasure.com

Salutations cordiales.

{{--Signature Medsurlink--}}

<div class="div-logo-mail">
    <img class="logo-footer" src="{{asset('/images/logo.png')}}" alt="Logo-Medicasure">
</div>
@endcomponent
