@component('mail::message')
# Notification de la commande
{{ $user }},
{{ config('app.name') }} vous remercie pour l'achat de l'offre {{ $cim_title }}



{{ config('app.name') }}
<div class="div-logo-mail">
    <img class="logo-footer" src="{{asset('/images/logo.png')}}" alt="Logo-Medicasure">
</div>
@endcomponent

