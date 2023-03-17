<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,400i,500,500i,600,700,800,900&display=swap" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Raleway:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900&display=swap' rel='stylesheet'>

    <title>Ordonnaance de {{ $patient->user->name }} du {{ $date }} par {{ $medecin->civilite ?? '' }} {{ $medecin->user->name }}</title>

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

    <h4 class="sous-titre-rapport">Ordonnance N°: Rx #{{ $ordonnance['id'] }}</h4>
    <p>Contact Patient{{ $patient->sexe == "M" ? "" : "e" }} : <a href="tel:+{{$patient->user->telephone}}">{{ number_format($patient->user->telephone, 0,","," ")  }}</a>  </p>


    @if($ordonnance['description'] !="")
        <h4 class="sous-titre-rapport">Prescription</h4>
        {!! $ordonnance['description'] !!}
    @endif

    <div>
        <p><b>{{ $medecin->civilite ?? '' }}  {{ $medecin->user->name }}</b> <br>
            Numéro d'ordre: {{ $medecin->numero_ordre }} <br>
            Téléphone:  {{ number_format($medecin->user->telephone, 0,","," ")  }} <br>
            Fait le : <b>{{ $date }}</b><br>
        </p>
        <p></p>
        @isset(explode('storage', $medecin->user->signature)[1])
            <div>
                <img style="width: 270px;"  src="{{ public_path('/storage/'.explode('storage', $medecin->user->signature)[1]) }}" />
            </div>
        @endisset
    </div>


</body>
</html>
