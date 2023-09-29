@component('mail::message')
# Medsurlink

Bonjour  <br>Votre
<strong>Code de verification</strong> est le suivant
 : <strong>{{$code}}</strong><br><br>
NB : Veuillez ne pas le partager
{{-- {{ config('app.name') }} --}}

<div class="div-logo-mail">
<<<<<<< HEAD
    <img class="logo-footer" src="https://www.back.medsurlink.com/images/logo.png" alt="Logo-Medicasure">
=======
    <img class="logo-footer" src="{{asset('/images/logo.png')}}" alt="Logo-Medicasure">
>>>>>>> eb48087e8dd32f1f379943a95c2cad5c28bfeeb9
</div>

<a href="{{ config('app.frontend_url') }}"> Medsurlink </a>
@endcomponent
