<?php
//
$url_global = "";
        $env = strtolower(config('app.env'));
        if ($env == 'local')
            $url_global = config('app.url_loccale');
        else if ($env == 'staging')
            $url_global = config('app.url_stagging');
        else
            $url_global = config('app.url_prod');
    $url_global = $url_global."/alertes?uuid=".$alerte->uuid
?>
<html>
    <head>
        <title>
                Nouvelle Alerte
        </title>
        <!-- CSS only -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    </head>
    <body>
        <h2>
        Nouvelle alerte concernant le patient : <strong>{{$alerte->patient->name}}</strong> pour les plaintes suivantes: <strong>{{$alerte->plainte}}</strong>
        </h2>
        <p>
            <h3><strong>Informations sur le patient :</strong></h3>
            Nom du Patient: <strong>{{$alerte->patient->name}}</strong><br>
            Email du Patient: <strong>{{$alerte->patient->email}}</strong><br>
            Telephone du Patient: <strong>{{$alerte->patient->telephone}}</strong><br>
            <br><br>
            <h3><strong>Informations sur le Souscripteur :</strong></h3>
            Nom du Souscripteur: <strong>{{$alerte->creator->name}}</strong><br>
            Email du Souscripteur: <strong>{{$alerte->creator->email}}</strong><br>
            Telephone du Souscripteur: <strong>{{$alerte->creator->telephone}}</strong><br>

        </p>
        <a href="{{ url(''.$url_global) }}"><button class="btn btn-primary"> Voir plus de details...</button></a>
    </body>
</html>
<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
