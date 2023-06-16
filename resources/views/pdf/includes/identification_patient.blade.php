@php
use Carbon\Carbon;
@endphp
<div class="info-user">
    <h2>Identification du patient</h2>
    <ul class="list-none">
        <li class="li-top">
            <span>
                <span class="title">Nom :</span>
                <span class="info">{{ $patient->user->name }}</span>
            </span>
            <span>
                <span class="title">Age :</span>
                <span class="info">{{ $patient->age }}</span>
            </span>
            <span>
                <span class="title">Sexe :</span>
                <span class="info">{{ $patient->sexe == "M" ? "Masculin" : "Féminin" }}</span>
            </span>
        </li>
        <li class="li-bottom">
            <span>
                <span class="title">Date de naissance :</span>
                <span class="info">{{ Carbon::parse($patient->date_de_naissance)->locale(config('app.locale'))->translatedFormat('jS F Y') }} </span>
            </span>
            <span>
                <span class="title">Numéro de dossier :</span>
                <span class="info">{{ $patient->dossier->numero_dossier }}</span>
            </span>
        </li>
    </ul>
</div>
