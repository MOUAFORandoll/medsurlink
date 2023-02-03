<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,400i,500,500i,600,700,800,900&display=swap" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Raleway:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900&display=swap' rel='stylesheet'>

    <title>Téléconsultation de {{ $patient->user->name }} du {{ $date }} par {{ $medecin->civilite ?? '' }} {{ $medecin->user->name }}</title>

    <style>
        body {
            font-size: 0.9em;
            line-height: 1.2;
            font-family: 'Montserrat', sans-serif;
            letter-spacing: 1.2px;
            color: #32325d;
            background-color: white;
        }

        h2 {
            color: #00ada7;
            font-weight: 600;
            text-align: left;
            font-size: 2em !important;
        }
        p{
            font-weight: 500;
        }
        h3,
            /*b {*/
            /*    color: #dee2e6;*/
            /*}*/

        td,
        th,hr {
            border: 1px solid #dee2e6;
            padding: 0.2em;

        }
        hr {
            border: 1px solid #dee2e6;
        }
        th{
            font-weight:700;
        }

        table {
            border-collapse: collapse;
        }
        .titre-rapport {
            text-align: center;
            text-transform: uppercase;
            color:#00ada7;
            font-weight: 900;
        }
        .sous-titre-rapport {
            text-transform: uppercase;
            color:#00ada7;
            /*font-size:0.8em;*/
        }

        .sous-titre-rapport::after{
            /* content:""; */
            display:block;
            width:60%;
            /* height:0.5px; */
            font-weight: 600;
            /* background-color:#dee2e6; */
            /* margin:0 auto;*/
            margin-top:3em;
        }

        .logo-rapport{
            width:200px;
            heigth: auto;
        }

        .rapport-logo-wrapper{
            margin-left:39%;

        }
        .title-table{
            font-weight : 600;

        }
        .sous-titre-rapport--table{
            text-transform: uppercase;
            color:#00ada7;
            font-size:0.8em;
        }
        /* DivTable.com */
        .divTable {
            display: table;
            width: 100%;
        }

        .divTableRow {
            display: table-row;
        }

        .divTableHeading {
            /*background-color: #eee;*/
            display: table-header-group;
        }

        .divTableCell,
        .divTableHead {
            /*border: 1px solid #999999;*/
            display: table-cell;
           /* padding: 3px 10px;*/
        }

        .divTableHeading {
            /*background-color: #eee;*/
            display: table-header-group;
            font-weight: bold;
        }

        .divTableFoot {
            /*background-color: #eee;*/
            display: table-footer-group;
            font-weight: bold;
        }

        .divTableBody {
            display: table-row-group;
        }
        .column {
            float: left;
            width: 50%;
        }
        .row{
            border-bottom: 1px solid #dee2e6;
        }
        /* Clear floats after the columns */
        .row:after {
            content: "";
            display: table;
            clear: both;
            width: 100%;
        }
        .row p{
            font-size: 14px;
        }
        .p{
            font-size: 14px;
        }
    </style>
</head>
<body>
    @php
        use Carbon\Carbon;
    @endphp

    <div class="justify-content-center">
        <h2>{{ $patient->user->name }}</h2>
        <h3>{{ Carbon::parse($patient->date_de_naissance)->locale(config('app.locale'))->translatedFormat('jS F Y') }}</h3>
        <h3>Sexe : {{ $patient->sexe == "M" ? "Masculin" : "Féminin" }}</h3>
    </div>
    {{--  $teleconsultation  --}}

      {{--   <div class="justify-content-center"> Allergies Information </div>
        <table style="width: 100%">
            <thead>
                <td class="title-table">Description</td>
                <td class="title-table">Date debut</td>
            </thead>
            <tbody>
                <tr>
                    <td>Description allergie</td><td>12/02/2023</td>
                </tr>
                <tr>
                    <td>Description allergie</td><td>12/02/2023</td>
                </tr>
            </tbody>
        </table> --}}


    <div style="color: black">
        <div>
            <div class="rapport-logo-wrapper">
                <img src="{{public_path('/images/logo.png')}}" class="logo-rapport" alt="" />
            </div>
            <p style="text-align: center"><b>{{ $teleconsultation["etablissements"][0]["name"] }}</b></p>
        </div>
        <p class="titre-rapport"><strong>Rapport de téléconsultation</strong></p>
        <br>
        <p>Honorée Consoeur, Honoré Confrère,</p>
        <p>J'ai vu en date du <strong>{{ Carbon::parse($teleconsultation["created_at"])->locale(config('app.locale'))->translatedFormat('jS F Y') }}</strong>, pour une téléconsultation médicale de type <b> {{ $teleconsultation['type']['libelle'] }}</b>, votre patient(e)
            <strong>{{ $patient->user->name }}</strong> né(e) le <strong> {{ Carbon::parse($patient->date_de_naissance)->locale(config('app.locale'))->translatedFormat('jS F Y') }} </strong>
            pour:  @forelse ($teleconsultation['motifs'] as $motif)
                        {{ $motif['description'] }}
                        @if(!$loop->last)
                        {{", "}}
                        @else
                        {{"."}}
                        @endif
                    @empty 
                    @endforelse
        </p>.

        @if(count($teleconsultation['motifs']) > 0)
            <h4 class="sous-titre-rapport">Motif(s) de téléconsultation</h4>
            <ol>
                @forelse ($teleconsultation['motifs'] as $motif)
                    <li>{{ $motif['description'] }}</li>
                @empty 
                @endforelse
            </ol>
        @endif


        {{-- <h4 class="sous-titre-rapport">Mode de vie</h4>
        <div class="divTable">
            <div class="divTableBody">
                <div class="divTableRow">

                    <div>
                        <table style="width: 100%">

                            <tbody>
                                <tr>
                                    <td>Profession </td>
                                    <td>Situation familiale </td>
                                    <td>Nombre d'enfants </td>
                                    <td>Tabac </td>
                                    <td>Alcool </td>
                                    <td>Autres </td>
                                </tr>
                                <tr>
                                    <td><span>Développeur web</span></td>
                                    <td><span>Cébibataire</span></td>
                                    <td><span>00</span></td>
                                    <td><span>{00 UPA</span></td>
                                    <td><span>Non</span></td>
                                    <td><span>RAS</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div> --}}
        @if (count($teleconsultation['antededents'])>0)
            <h4 class="sous-titre-rapport">Antédédents</h4>
            <div class="divTable">
                <div class="divTableBody">
                    <div class="divTableRow">
                        <div class="divTableCell">
                            <table style="width: 100%">
                                <thead>
                                    <tr>
                                        <th class="title-table">Type</th>
                                        <th class="title-table">Description</th>
                                        <th class="title-table">Date début</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($teleconsultation['antededents'] as $antededent)
                                        <tr>
                                            <td>{{ $antededent['type']['libelle'] }}</td>
                                            <td>{!! $antededent['description'] !!}</td>
                                            <td>{{ $antededent['date'] }}</td>
                                        </tr>
                                    @empty
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{-- <h4 class="sous-titre-rapport">Parametres</h4>
        <div class="row" >
            <div class="list">Poids (kg) : <strong></strong> </div>
            <div class="list">Taille (cm): <strong></strong></div>
            <div class="list">Bmi (kg/m²): <strong></strong></div>
            <div class="list">TA Systolique (mmHg) : <strong></strong></div>
            <div class="list">TA Diastolique (mmHg) : <strong></strong></div>
            <div class="list">Température (°C): <strong></strong></div>
            <div class="list">Fréquence cardiaque (bpm) : <strong></strong></div>
            <div class="list">Fréquence respiratoire (cpm) : <strong></strong></div>
            <div class="list">sato2 (%) : <strong></strong></div>
        </div> --}}
    </div>

    @if (count($teleconsultation['allergies'])>0)
        <h4 class="sous-titre-rapport">Allergies</h4>
        <span>
            @forelse ($teleconsultation['allergies'] as $allergie)
                {{ $allergie['description'] }}
                @if(!$loop->last)
                {{", "}}
                @else
                {{"."}}
                @endif
            @empty 
            @endforelse
        </span>
    @endif

    @if (count($teleconsultation['anamneses'])>0)
        <h4 class="sous-titre-rapport">Anamnèse</h4>
        <div class="row">
            @forelse ($teleconsultation['anamneses'] as $anamnese)
                <span>{{$loop->iteration}}. {!! $anamnese['fr_description'] !!}</span>
                <div class="row">
                    Description de l'anamnèse:
                    {!! isset(json_decode($anamnese['pivot']['data'])->anamnese) ? json_decode($anamnese['pivot']['data'])->anamnese : '' !!}
                </div>
            @empty
            @endforelse
        </div>
    @endif

    @if (count($teleconsultation['examen_cliniques'])>0)
        <h4 class="sous-titre-rapport">Examen(s) clinique(s)</h4>
        <div class="row">
            <ol>
                @forelse ($teleconsultation['examen_cliniques'] as $examen_clinique)
                    <li>{{ $examen_clinique['fr_description'] }}</li>
                @empty
                @endforelse
            </ol>
            <span>Description examen clinique: {!! $teleconsultation['description_examen_clinique'] !!}</span>

        </div>
    @endif

    @if (count($teleconsultation['examen_complementaires'])>0)
        <h4 class="sous-titre-rapport">Examen(s) complémentaire(s)</h4>
        <div class="row">
            <ol>
                @forelse ($teleconsultation['examen_complementaires'] as $examen_complementaire)
                    <li>{{ $examen_complementaire['fr_description'] }}</li>
                @empty
                @endforelse
            </ol>
        </div>
    @endif

    @if (count($teleconsultation['diagnostics'])>0)
        <h4 class="sous-titre-rapport">Diagnostic ICD</h4>
        <div class="row">
            <ol>
                @forelse ($teleconsultation['diagnostics'] as $diagnostic)
                    <li><span style="padding:0 40px 0 0;">{{ $diagnostic['code_icd'] }}</span> {{ $diagnostic['name'] }}</li>
                @empty
                @endforelse
            </ol>
        </div>
        <div class="row">
            <h4 class="sous-titre-rapport">Description du Diagnostic</h4>
            {!! $teleconsultation['description_diagnostic'] !!}
        </div>
    @endif

    <div class="row">
        <h4 class="sous-titre-rapport">Conduite à tenir</h4>
        {!! $teleconsultation['cat'] !!}
    </div>

    @if (count($teleconsultation['ordonnances'])>0)
        <div class="row">
            <h4 class="sous-titre-rapport">Ordonnances</h4>
            <ol>
                @forelse ($teleconsultation['ordonnances'] as $ordonnance)
                    <li>{!! $ordonnance['description'] !!}</li>
                @empty
                @endforelse
            </ol>
        </div>
    @endif


    <h4></h4>
    <p>Je vous remercie de m'avoir adressé votre patient(e) et vous adresse mes salutations confraternelles.</p>
    <p><i>Dossier relu et validé par l'équipe Medicasure</i></p>

    <h4 class="sous-titre-rapport">Medecin ayant fait votre téléconsultation</h4>

    <div>
        @isset(explode('storage', $medecin->user->signature)[1]))
            <div>
                <img width="280px" style="margin-top: 200px;" height="auto" src="{{ public_path('/storage/'.explode('storage', $medecin->user->signature)[1]) }}" />
            </div>
        @endisset

        <p><b>{{ $medecin->civilite ?? '' }}  {{ $medecin->user->name }}</b></p>
        <p>Numéro d'ordre: {{ $medecin->numero_ordre }}</p>
        <p style="text-align: right"> Fait le : <b>{{ $date }}</b></p>
    </div>


</body>
</html>
