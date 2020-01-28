<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,400i,500,500i,600,700,800,900&display=swap" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Raleway:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900&display=swap' rel='stylesheet'>

    <title>Medsurlink</title>
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
        th {
            border: 1px solid #dee2e6;
            padding: 0.5em;

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
            content:"";
            display:block;
            width:60%;
            height:0.5px;
            font-weight: 600;
            background-color:#dee2e6;
            /* margin:0 auto;*/
            margin-top:3em;
        }

        .logo-rapport{
            width:200px;
            heigth: auto;
        }

        .rapport-logo-wrapper{
            margin-left:43%;

        }
        .title-table{
            font-weight : 600;

        }
        .sous-titre-rapport--table{
            text-transform: uppercase;
            color:#00ada7;
            font-size:0.8em;
        }
    </style>
</head>
<body>

@isset($dossier)
    <div class="justify-content-center">
        <h2>{{is_null($dossier->patient->user->prenom) ? "" :  $dossier->patient->user->prenom }} {{$dossier->patient->user->nom}}</h2>
        <h3>{{$dossier->patient->date_de_naissance}}</h3>
        <h3>Sexe : {{$dossier->patient->sexe}}</h3>
    </div>
    <div class="justify-content-center"> Allergies Information </div>
    @forelse($dossier->allergies as $allergie)
        <table>
            <thead>
            <td class="title-table">Description</td>
            <td class="title-table">Date debut</td>
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
    <div style="color: black">
        @if(!is_null($consultationMedecine->etablissement))
            <div>
                @if(!is_null($consultationMedecine->etablissement->logo))
                    <div class="rapport-logo-wrapper">
                        <img src="{{public_path('/storage/'.$consultationMedecine->etablissement->logo)}}" class="logo-rapport" alt="" />
                    </div>
                @endif
                <p style="text-align: center"><b>{{$consultationMedecine->etablissement->name}}</b></p>
            </div>
        @endif
        <p class="titre-rapport"><strong>Rapport de consultation</strong></p>
        <br>
        <p>Honorée Consoeur, Honorée Confrère,</p>
        <p>J'ai vue en date du <strong>{{\Carbon\Carbon::parse($consultationMedecine->date_consultation)->format('d/m/Y')}}</strong>, pour une consultation de<b> médecine générale</b>, votre patient(e)
            <strong>{{$consultationMedecine->dossier->patient->user->nom}}</strong> né(e) le <strong>{{\Carbon\Carbon::parse($consultationMedecine->dossier->patient->date_de_naissance)->format('d/m/Y')}}</strong>
            pour:
            @forelse($consultationMedecine->motifs as $motif)
                <strong>{{$motif->description}},</strong>
            @empty
                <strong></strong>
            @endforelse
        </p>

        <h4 class="sous-titre-rapport">Motif(s) de Consultation</h4>
        @forelse($consultationMedecine->motifs as $motif)
            <p>{{$motif->description}}</p>
        @empty
            <strong></strong>
        @endforelse

        <h4 class="sous-titre-rapport">Anamnèse</h4>
        <p>{!! $consultationMedecine->anamese !!}</p>

        <h4 class="sous-titre-rapport">Mode de vie</h4>
        <p class="ml-5">Profession : <strong>{{$consultationMedecine->profession}}</strong></p>
        <p class="ml-5">Situation familiale : <strong>{{$consultationMedecine->situation_familiale}}</strong></p>
        <p class="ml-5">Nombre d'enfants : <strong>{{$consultationMedecine->nbre_enfant}}</strong></p>
        <p class="ml-5">Tabac : <strong>{{$consultationMedecine->tabac}}</strong></p>
        <p class="ml-5">Alcool : <strong>{{$consultationMedecine->alcool}}</strong></p>
        <p class="ml-5">Autres : <strong>{!! $consultationMedecine->autres !!}</strong></p>

        <h4 class="sous-titre-rapport--table">Antédédents</h4>
        <table>
            <thead>
            <td class="title-table">Type</td>
            <td class="title-table">Description</td>
            <td class="title-table">Date debut</td>
            </thead>
            <tbody>
            <tr></tr>
            @forelse($consultationMedecine->dossier->antecedents as $antecedent)
                <tr>
                    <td>{{$antecedent->type}}</td>
                    <td>{{$antecedent->description}}</td>
                    <td>{{\Carbon\Carbon::parse($antecedent->date)->format('d/m/Y')}}</td>
                </tr>
            @empty
                <strong></strong>
            @endforelse
            </tbody>
        </table>

        <h4 class="sous-titre-rapport--table">Allergies</h4>
        <table>
            <thead>
            <td class="title-table">Description</td>
            {{--            <td>Date debut</td>--}}
            </thead>
            <tbody>
            <tr></tr>
            @forelse($consultationMedecine->dossier->allergies as $allergie)
                <tr>
                    <td>{{$allergie->description}}</td>
                    {{--                    <td>{{\Carbon\Carbon::parse($allergie->date)->format('d/m/Y')}}</td>--}}
                </tr>
            @empty
                <strong></strong>
            @endforelse
            </tbody>
        </table>

        <h4 class="sous-titre-rapport--table">Traitement actuel</h4>
        <table>
            <thead>
            <td class="title-table">Description</td>
            <td class="title-table">Date prescription</td>
            </thead>
            <tbody>
            <tr></tr>
            @foreach($consultationMedecine->dossier->traitements as $traiement)
                @if($loop->last)
                    <tr>
                        <td>{{$traiement->description}}</td>
                        <td>{{\Carbon\Carbon::parse($traiement->created_at)->format('d/m/Y')}}</td>
                    </tr>
                @endif
            @endforeach
            </tbody>
        </table>

        <h4 class="sous-titre-rapport">Parametres</h4>
        @foreach($consultationMedecine->parametresCommun as $parametre)
            @if($loop->first)
                <p>Poids (kg) : {{$parametre->poids}} </p>
                <p>Taille (cm): {{$parametre->taille}}</p>
                <p>Bmi (kg/m²): {{$parametre->bmi}}</p>
                <p>TA Systolique (mmHg) : {{$parametre->ta_systolique}}</p>
                <p>TA Diastolique (mmHg) : {{$parametre->ta_diastolique}}</p>
                <p>Température (°C): {{$parametre->temperature}}</p>
                <p>Fréquence cardiaque (bpm) : {{$parametre->frequence_cardiaque}}</p>
                <p>Fréquence respiratoire (cpm) : {{$parametre->frequence_respiratoire}}</p>
                <p>sato2 (%) : {{$parametre->sato2}}</p>
            @endif


        @endforeach


        @if(!is_null($consultationMedecine->examen_clinique))
            <h4 class="sous-titre-rapport">Examen(s) clinique(s)</h4>
            <p>{!!$consultationMedecine->examen_clinique!!}</p>

        @endif

        @if(!is_null($consultationMedecine->examen_complementaire))
            <h4 class="sous-titre-rapport">Examen(s) complémentaire(s)</h4>
            <p>{!!$consultationMedecine->examen_complementaire!!}</p>
        @endif


        @if(!is_object(collect($consultationMedecine->conclusions->toArray())->first()))
            @if(!is_null($consultationMedecine->conclusions->first()))
                <h4 class="sous-titre-rapport">Diagnostic</h4>
                <p>{!!($consultationMedecine->conclusions->first())->description!!}</p>
            @endif
        @endif


        @if($consultationMedecine->traitement_propose)
            <h4 class="sous-titre-rapport">Conduite à tenir</h4>
            <p>{!! $consultationMedecine->traitement_propose !!}</p>
            @if(count($medecins) != 0)
                <h4>Medecin ayant vérifié votre consultation</h4>
                @foreach($medecins as $medecin)
                    @if(!is_null($medecin->user))
                        <p>{{is_null($medecin->user->prenom) ? "" :  $medecin->user->prenom }} {{$medecin->user->nom}}</p>
                    @endif
                @endforeach
            @endif


            @if(!is_null($consultationMedecine->file))
                <p>Consultter la pièce jointe
                    <a href="{{public_path('storage/')}}{{$consultationMedecine->file}}">{{(explode("/",$consultationMedecine->file))[count(explode("/",$consultationMedecine->file)) - 1]}}</a>
                </p>
            @endif
        @endif
    </div>

@endisset

@isset($resultatLabo)
@endisset

@isset($resultatImagerie)
@endisset
<p style="text-align: right"> Date de création : <b>{{\Carbon\Carbon::parse()->format('d/m/Y')}}</b></p>

@isset($signature)
    @if(!is_null($signature))
        <div>
            <img  style="float: right" width="300px" height="300px" src={{public_path('/storage/'.$signature)}} />
        </div>
    @endif
@endisset
@if(!is_null($praticiens->user))
    <p><b>{{$praticiens->civilite}} {{is_null($praticiens->user->prenom) ? "" :  $praticiens->user->prenom }} {{$praticiens->user->nom}}</b></p>
{{--    @if(!is_null($praticiens->numero_ordre))--}}
{{--        @if(strlen($praticiens->numero_ordre) > 0)--}}
{{--            <p>Numéro d'ordre: {{$praticiens->numero_ordre}}</p>--}}
{{--        @endif--}}
{{--    @endif--}}
@endif

@if(count($medecins) != 0)

    @foreach($medecins as $medecin)
        @if(!is_null($medecin->user))
            @if(!is_null($medecin->signature))
                <div>
                    <img width="300px" height="300px" src={{public_path('/storage/'.$medecin->signature)}} />
                </div>
            @endif

            <p>{{$medecin->civilite}} {{is_null($medecin->user->prenom) ? "" :  $medecin->user->prenom }} {{$medecin->user->nom}}</p>

{{--            @if(!is_null($medecin->numero_ordre))--}}
{{--                @if(strlen($medecin->numero_ordre) > 0)--}}
{{--                    <p>Numéro d'ordre: {{$medecin->numero_ordre}}</p>--}}
{{--                @endif--}}
{{--            @endif--}}
        @endif
    @endforeach
@endif
<p>Je vous remercie de m'avoir adressé votre patient(e) et vous adresse mes salutations confraternelles.</p>

<p><i>Dossier relu et validé par l'équipe Medicasure</i></p>
</body>
</html>
