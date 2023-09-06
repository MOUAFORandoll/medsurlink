@component('mail::message')
# Medsurlink

Bonjour  <br>Votre
<strong>Code OTP de verification</strong> est le suivant
 : <strong>{{$code}}</strong><br><br>
NB : Veuillez ne pas le partager
{{-- {{ config('app.name') }} --}}

<div class="div-logo-mail">
    <img class="logo-footer" src="https://www.back.medsurlink.com/images/logo.png" alt="Logo-Medicasure">
</div>

<a href="{{ config('app.frontend_url') }}"> Medsurlink </a>
@endcomponent
