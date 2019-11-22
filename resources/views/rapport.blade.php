<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href='https://fonts.googleapis.com/css?family=Raleway:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900&display=swap' rel='stylesheet'>
    <title>Medicalink</title>
</head>
<style>
    body{

        font-size : 1em ;
        line-height : 1.2;
        font-weight : 500;
        font-family: 'Raleway', sans-serif;
        letter-spacing : 1.3px;
        color : #333333

    }
    h2 {
        color: #00ada7;
        font-weight: 600;
        text-align : left;
        font-size : 2em !important;
    }

    h3, b {
        color : #91c01c;
    }
    td,th{
        border: 1px solid #333333;
    }
    table{
        border-collapse: collapse;
    }
</style>
<body>
yol
@isset($dossier)
    <div class="justify-content-center">
        <h2>{{is_null($dossier->patient->user->prenom) ? "" :  is_null($dossier->patient->user->prenom) }} {{$dossier->patient->user->nom}}</h2>
        <h3>{{$dossier->patient->date_de_naissance}}</h3>
        <h3>Sexe : {{$dossier->patient->sexe}}</h3>
    </div>

    <div class="justify-content-center"> Allergies Information </div>
    @forelse($dossier->allergies as $allergie)
    <table>
        <thead>
        <td>Description</td>
        <td>Date debut</td>
        </thead>
        <tbody>
        <td>{{$allergie->description}}</td>
        <td>{{$allergie->date}}</td>
        </tbody>
    </table>
    @empty
        <p>Aucune allergie</p>
    @endforelse

@endisset

@isset($consultationObstetrique)
@endisset

@isset($consultationMedecine)
@endisset

@isset($resultatLabo)
@endisset

@isset($resultatImagerie)
@endisset


</body>
</html>
