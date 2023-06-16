@component('mail::message')
# Medsurlink

Hello <strong>{{ucfirst($souscripteur->prenom).'  '.strtoupper($souscripteur->nom)}}</strong>,<br>
Vous êtes prié d'effectuer une validation des examens complémentaire de votre proche  <strong>{{ucfirst($patient->prenom).'  '.strtoupper($patient->nom)}}</strong>,<br><br>
<table>
    <thead>
        <tr>
            <th>N°</th>
            <th>Examens Complémentaires</th>
            <th>Prix</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($examens as $examen)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $examen->fr_description }} </td>
                <td>{{ number_format($examen->prix, 0, ',', ' ') }}</td>
            </tr>
        @empty
        @endforelse
    </tbody>
    <tfoot>
        <tr>
            <th colspan="2">Total</th>
            <th>{{ number_format($examens->sum('prix'), 0, ',', ' ') }}</th>
        </tr>
    </tfoot>
</table>
<br>
Merci de vous connecter à <a href="https://www.medsurlink.com/">Medsurlink</a> pour effectuer la validation financière.

{{ config('app.name') }}
<div class="div-logo-mail">
    <img class="logo-footer" src="https://www.back.medsurlink.com/images/logo.png" alt="Logo-Medicasure">
</div>
@endcomponent
