<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,400i,500,500i,600,700,800,900&display=swap" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Raleway:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900&display=swap' rel='stylesheet'>

    <title>Bon de prise en charge de {{ $patient->user->name }} du {{ $date }} par {{ $medecin->civilite ?? '' }} {{ $medecin->user->name }}</title>

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

   {{--  <div class="justify-content-center">
        <h2>{{ $patient->user->name }}</h2>
        <h3>{{ Carbon::parse($patient->date_de_naissance)->locale(config('app.locale'))->translatedFormat('jS F Y') }}</h3>
        <h3>Sexe : {{ $patient->sexe == "M" ? "Masculin" : "Féminin" }}</h3>
    </div> --}}

    <h4 class="sous-titre-rapport">BON DE PRISE EN CHARGE: {{ $bon_prise_en_charge['id'] }}</h4>
    <p>Concerne {{ $patient->sexe == "M" ? "M." : "Mme" }} {{ $patient->user->name }}, patient{{ $patient->sexe == "M" ? "" : "e" }} né{{ $patient->sexe == "M" ? "" : "e" }} le {{ Carbon::parse($patient->date_de_naissance)->locale(config('app.locale'))->translatedFormat('jS F Y') }}, résidant à {{ $patient->user->ville }} – {{ $patient->user->pays }}</p>
    <p> Honorée Consoeur, Honoré Confrère, bonjour</p>
    <p>Voudriez-vous prendre contact avec {{ $patient->sexe == "M" ? "le" : "la" }} patient{{ $patient->sexe == "M" ? "" : "e" }} sus mentionnée
        @if (count($bon_prise_en_charge['teleconsultations']) > 0)
            en vue d'une consultation de {{ $bon_prise_en_charge['teleconsultations'][0]['type']['libelle'] }} le {{ Carbon::parse($bon_prise_en_charge['rendez_vous'][0]['date'])->locale(config('app.locale'))->translatedFormat('jS F Y') }}
        @endif
    </p>
    <p>Contact Patient{{ $patient->sexe == "M" ? "" : "e" }} : <a href="tel:+{{$patient->user->telephone}}">{{ number_format($patient->user->telephone, 0,","," ")  }}</a>  </p>

    @if(count($bon_prise_en_charge['motifs']) > 0)
        <h4 class="sous-titre-rapport">Motifs principaux de consultation initiale</h4>
        <ol>
            @forelse ($bon_prise_en_charge['motifs'] as $motif)
                <li>{{ $motif['description'] }}</li>
            @empty 
            @endforelse
        </ol>
    @endif

    @if($bon_prise_en_charge['ligne_temps'] !="")
        <h4 class="sous-titre-rapport">Motifs principaux de consultation initiale</h4>
        <ol>
            @if (count($bon_prise_en_charge['ligne_temps']['motifs']) > 0)
                @forelse ($bon_prise_en_charge['ligne_temps']['motifs'] as $motif)
                    <li>{{ $motif['description'] }}</li>
                @empty 
                @endforelse
            @else
                <li>{{ $bon_prise_en_charge['ligne_temps']['motif']['description'] }}</li>
            @endif
        </ol>
    @endif

    <h4 class="sous-titre-rapport">Plainte</h4>
    <p>{!! $bon_prise_en_charge['plainte'] !!}</p>

    <h4 class="sous-titre-rapport">Bulletin d’examens / Ordonnances Disponibles</h4>
    <p>{{ $bon_prise_en_charge['plainte'] }}</p>

    <h4 class="sous-titre-rapport">Rapports / Résultats disponibles</h4>
    <p>{{ $bon_prise_en_charge['plainte'] }}</p>

    <p>N’hésitez pas à archiver votre rapport de prise en charge dans le dossier medical du patient sur Medsurlink <a href="https://www.medsurlink.com" target="_blank">medsurlink.com</a>.</p>
    <p>Si vous rencontrez des difficultés, n’hésitez pas à nous le transmettre par mail à  <a href="mailto:medical@medicasure.com" target="_blank">medical@medicasure.com</a> .</p>
    <p>Je vous remercie d’avance de votre diligence.</p>
    <p>Sincères salutations</p>


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








@extends('pdf.layouts.pdf')
@section('title', 'Le titre')
@section('content')
  <div id="content" class="default-margin">
    @include('pdf.includes.identification_patient')
    <div class="content mt-2">
      <h1>Bon de prise en charge</h1>
      <div class="content-text">
          <p>
              Concerne <strong>Mme Terfa DOUALA</strong>, patiente née le <strong>1er janvier 2004</strong>, résidant à <strong>Mbouda – Cameroon</strong> 
          </p>
          <p>
              Honorée Consœur, Honoré Confrère, bonjour <br /><br />
              Voudriez-vous prendre contact avec la patiente sus mentionnée en vue d'une consultation de Ostéoarticulaire le <strong>4 avril 2022</strong> <br /><br />
              Contact Patiente : <strong>237 674 315 311</strong>
          </p>
      </div>
      <fieldset class="content-field mt-2">
          <legend>MOTIFS PRINCIPAUX DE CONSULTATION INITIALE</legend>
          <ul class="content-field-list list-none">
              <li>1. Tuméfaction/gonflement loc. peau</li>
              <li>2. Douleur abdominale</li>
              <li>3. Prolapsus hémorrhoidaire</li>
          </ul>
      </fieldset>
      <fieldset class="content-field mt-2">
          <legend>Plaintes</legend>
          <p>
              Necessitatibus voluptas quos doloribus. Quia saepe ut vel eaque est consequatur excepturi nam.
              Et voluptate illum quia molestiae. Est dolorem unde architecto sunt voluptas voluptatibus aut ea.
          </p>
      </fieldset>
      <fieldset class="content-field mt-2">
          <legend>BULLETIN D’EXAMENS / ORDONNANCES DISPONIBLES</legend>
          <p>
              Necessitatibus voluptas quos doloribus. Quia saepe ut vel eaque est consequatur excepturi nam.
              Et voluptate illum quia molestiae. Est dolorem unde architecto sunt voluptas voluptatibus aut ea. 
          </p>
      </fieldset><br>

      <table>
        <tr>
          <th>#</th>
          <th>Catégories</th>
          <th>Examen</th>
        </tr>
        <tr>
          <td>1</td>
          <td>ORH</td>
          <td>Germany</td>
        </tr>
        <tr>
          <td>2</td>
          <td>NFS</td>
          <td>Mexico</td>
        </tr>
        <tr>
          <td>3</td>
          <td>NFS</td>
          <td>Mexico</td>
        </tr>
      </table>

      <div class="content-text">
        <p>
            N’hésitez pas à archiver votre rapport de prise en charge dans le dossier medical du patient sur Medsurlink <strong>medsurlink.com</strong>. 
        </p>
        <p>
            Si vous rencontrez des difficultés, n’hésitez pas à nous le transmettre par mail à <strong>medical@medicasure.com</strong>.
        </p>
        <p>
          Je vous remercie d’avance de votre diligence. <br/>
          Sincères salutations
        </p>
      </div>
      @include('pdf.includes.signature_medecin')
    </div>
  </div>
@endsection

