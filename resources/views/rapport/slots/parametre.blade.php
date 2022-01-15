<h4 class="sous-titre-rapport">Parametres</h4>
@if(count($parametres)>=1)
    @foreach($parametres as $parametre)
        @if($loop->first)
            <p>Poids (kg) : <strong>{{$parametre->poids}}</strong> </p>
            <p>Taille (cm): <strong>{{$parametre->taille}}</strong></p>
            <p>Bmi (kg/m²): <strong>{{$parametre->bmi}}</strong></p>
            <p>Périmetre abdominal (cm): <strong>{{$parametre->perimetre_abdominal}}</strong></p>
            <p>TA Systolique (mmHg) : <strong>{{$parametre->ta_systolique}}</strong></p>
            <p>TA Diastolique (mmHg) : <strong>{{$parametre->ta_diastolique}}</strong></p>
            <p>Température (°C): <strong>{{$parametre->temperature}}</strong></p>
            <p>Fréquence cardiaque (bpm) : <strong>{{$parametre->frequence_cardiaque}}</strong></p>
            <p>Fréquence respiratoire (cpm) : <strong>{{$parametre->frequence_respiratoire}}</strong></p>
            <p>sato2 (%) : <strong>{{$parametre->sato2}}</strong></p>
        @endif
    @endforeach
@else
    <p>Poids (kg) :</p>
    <p>Taille (cm): </p>
    <p>Bmi (kg/m²):</p>
    <p>TA Systolique (mmHg) :</p>
    <p>TA Diastolique (mmHg) : </p>
    <p>Température (°C):</p>
    <p>Fréquence cardiaque (bpm) : </p>
    <p>Fréquence respiratoire (cpm) : </p>
    <p>sato2 (%) : </p>
@endif
