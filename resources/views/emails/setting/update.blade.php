@component('mail::message')
# Medicalink

Hello <strong>{{ucfirst($user->prenom).'  '.strtoupper($user->nom)}}</strong>,<br>
<p>Vos informations ont été mise à jour avec succès</p><br>
<a href="https:www.medsurlink.com">Consulter</a><br>

Thanks,<br>
{{ config('app.name') }}
<div class="div-logo-mail">
    <img class="logo-footer" src="{{asset('/images/logo.png')}}" alt="Logo-Medicasure" height="50px" width="150px">
</div>
@endcomponent
