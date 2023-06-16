@component('mail::message')
# Notification de paiement
{{ $user }},
{{ config('app.name') }} vous remercie pour le  {{ $prestation }} du patient {{ $patient }}



L'équipe Medicasure
</br>
<div class="div-logo-mail">
    <img class="logo-footer" src="https://www.back.medsurlink.com/images/logo.png" alt="Logo-Medicasure">
</div>
@endcomponent

