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
    </head>
    <body>
        <p>
        Nouvelle alerte concernant le patient : <strong>{{$alerte->patient->name}}</strong> pour les plaintes suivantes: <strong>{{$alerte->plainte}}</strong>
        </p>
        <p>
            <p><strong>Informations sur le patient :</strong></p>
            Nom : <strong>{{$alerte->patient->name}}</strong><br>
            Email : <strong>{{$alerte->patient->email}}</strong><br>
            Telephone : <strong>{{$alerte->patient->telephone}}</strong><br>
            <br>
            <p><strong>Informations sur l'emetteur :</strong></p>
            Nom : <strong>{{$alerte->creator->name}}</strong><br>
            Email : <strong>{{$alerte->creator->email}}</strong><br>
            Telephone : <strong>{{$alerte->creator->telephone}}</strong><br>

        </p>
        <a href="{{ url(''.$url_global) }}" class="btn btn-primary"><button class="btn btn-primary"> Voir plus de details...</button></a>
    </body>
</html>