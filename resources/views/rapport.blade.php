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
            padding: 3px 10px;
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
    </style>
</head>
<body>

@isset($dossier)
    <div class="justify-content-center">
        <h2>{{is_null($dossier->patient->user->prenom) ? "" :  $dossier->patient->user->prenom }} {{$dossier->patient->user->nom}}</h2>
        <h3>{{$dossier->patient->date_de_naissance}}</h3>
        <h3>Sexe : {{$dossier->patient->sexe}}</h3>
    </div>

    @if(count($dossier->allergies) >0)
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
    @endif

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
        <p>Honorée Consoeur, Honoré Confrère,</p>
        <p>J'ai vu en date du <strong>{{\Carbon\Carbon::parse($consultationMedecine->date_consultation)->format('d/m/Y')}}</strong>, pour une consultation de<b> médecine générale</b>, votre patient(e)
            <strong>{{$consultationMedecine->dossier->patient->user->nom}}</strong> né(e) le <strong>{{\Carbon\Carbon::parse($consultationMedecine->dossier->patient->date_de_naissance)->format('d/m/Y')}}</strong>
            pour:
            @forelse($consultationMedecine->motifs as $motif)
                <strong>{{$motif->description}},</strong>
            @empty
                <strong></strong>
            @endforelse
        </p>.

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
        <p class="ml-5">Tabac : <strong>{{$consultationMedecine->tabac}} UPA</strong></p>
        <p class="ml-5">Alcool : <strong>{{$consultationMedecine->alcool}}</strong></p>
        <p class="ml-5">Autres : <strong>{!! $consultationMedecine->autres !!}</strong></p>

{{--        @if(count($consultationMedecine->dossier->antecedents) >0)--}}
            <h4 class="sous-titre-rapport--table">Antédédents</h4>
            <div class="divTable">
                <div class="divTableBody">
                    <div class="divTableRow">

                        <div class="divTableCell">
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
                                @foreach($consultationMedecine->dossier->consultationsMedecine as $consultation)
                                    @if(\Carbon\Carbon::parse($consultation->updated_at)->lessThan($consultationMedecine->updated_at))
                                        @foreach($consultation->conclusions as $conclusion)
                                            @if(!is_null($conclusion->description) && $conclusion->description !=='null')
                                                <tr>
                                                    <td>Consultation</td>
                                                    <td>{{$conclusion->description}}</td>
                                                    <td>{{\Carbon\Carbon::parse($conclusion->updated_at)->format('d/m/Y')}}</td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    @endif
                                @endforeach
                                @foreach($consultationMedecine->dossier->cardiologies as $cardiologie)
                                    @if(\Carbon\Carbon::parse($cardiologie->updated_at)->lessThan($consultationMedecine->updated_at))
                                        @if(!is_null($cardiologie->conclusion) && $cardiologie->conclusion !=='null')
                                            <tr>
                                                <td>Consultation</td>
                                                <td>{{$cardiologie->conclusion}}</td>
                                                <td>{{\Carbon\Carbon::parse($cardiologie->updated_at)->format('d/m/Y')}}</td>
                                            </tr>
                                        @endif
                                    @endif
                                    @endforeach
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
{{--        @endif--}}
        @if(count($consultationMedecine->dossier->allergies)>0)
            <h4 class="sous-titre-rapport--table">Allergies</h4>
            <div class="divTable">
                <div class="divTableBody">
                    <div class="divTableRow">

                        <div class="divTableCell">
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
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @if(count($consultationMedecine->dossier->traitements) >0)
            <h4 class="sous-titre-rapport--table">Traitement actuel</h4>
            <div class="divTable">
                <div class="divTableBody">
                    <div class="divTableRow">

                        <div class="divTableCell">
                            <table>
                                <thead>
                                <td class="title-table">Description</td>
                                {{--                                <td class="title-table">Date prescription</td>--}}
                                </thead>
                                <tbody>
                                <tr></tr>
                                @foreach($consultationMedecine->dossier->traitements as $traiement)
                                    @if($loop->last)
                                        <tr>
                                            <td>{{$traiement->description}}</td>
                                            {{--                                            <td>{{\Carbon\Carbon::parse($traiement->created_at)->format('d/m/Y')}}</td>--}}
                                        </tr>
                                    @endif
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <h4 class="sous-titre-rapport">Parametres</h4>
        @if(count($consultationMedecine->parametresCommun)>=1)
            @foreach($consultationMedecine->parametresCommun as $parametre)
                @if($loop->first)
                    <p>Poids (kg) : <strong>{{$parametre->poids}}</strong> </p>
                    <p>Taille (cm): <strong>{{$parametre->taille}}</strong></p>
                    <p>Bmi (kg/m²): <strong>{{$parametre->bmi}}</strong></p>
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




        @if(!is_null($consultationMedecine->examen_clinique) )
            <h4 class="sous-titre-rapport">Examen clinique</h4>
            @if($consultationMedecine->examen_clinique != 'null')
                <p>{!!$consultationMedecine->examen_clinique!!}</p>
            @endif
        @endif

        @if(!is_null($consultationMedecine->examen_complementaire))
            <h4 class="sous-titre-rapport">Examen(s) complémentaire(s)</h4>
            @if($consultationMedecine->examen_complementaire != 'null')
                <p>{!!$consultationMedecine->examen_complementaire!!}</p>
            @endif
        @endif


        @if(!is_object(collect($consultationMedecine->conclusions->toArray())->first()))
            @if(!is_null($consultationMedecine->conclusions->first()))
                <h4 class="sous-titre-rapport">Diagnostic</h4>
                <p>{!!($consultationMedecine->conclusions->first())->description!!}</p>
            @endif
        @endif


        @if(strlen($consultationMedecine->traitement_propose)>0)
            <h4 class="sous-titre-rapport">Conduite à tenir</h4>
            @if($consultationMedecine->traitement_propose != 'null')
                <p>{!! $consultationMedecine->traitement_propose !!}</p>
            @endif
        @endif

        @if((!is_null($consultationMedecine->file) && $consultationMedecine->file != 'null') || count($consultationMedecine->files)>0)
            <p>Consulter les pièces jointes</p>
            @if(!is_null($consultationMedecine->file) && $consultationMedecine->file != 'null')
                <a href="{{config('app.url')}}/public/storage/{{$consultationMedecine->file}}">{{(explode("/",$consultationMedecine->file))[count(explode("/",$consultationMedecine->file)) - 1]}}</a><br>
            @endif
            @if(count($consultationMedecine->files)>0)
                @foreach($consultationMedecine->files as $file)
                    <a href="{{config('app.url')}}/public/storage/{{$file->chemin}}">{{$file->nom}}</a><br>
                @endforeach
            @endif
        @endif

    </div>

@endisset

@isset($resultatLabo)
@endisset

@isset($resultatImagerie)
@endisset


<p>Je vous remercie de m'avoir adressé votre patient(e) et vous adresse mes salutations confraternelles.</p>
@if($consultationMedecine->dossier->patient->user->isMedicasure == '1')
    <p><i>Dossier relu et validé par l'équipe Medicasure</i></p>
@endif
@if(count($medecins) != 0)
    <h4>Medecin(s) ayant revisité votre consultation</h4>
    @foreach($medecins as $medecin)
        @if(!is_null($medecin->user))
            <div style="display: inline">
                @if(!is_null($medecin->signature))
                    <div>
                        <img width="300px" height="auto" src={{public_path('/storage/'.$medecin->signature)}} />
                    </div>
                @endif

                <p>{{$medecin->civilite}} {{is_null($medecin->user->prenom) ? "" :  $medecin->user->prenom }} {{$medecin->user->nom}}</p>

                @if(!is_null($medecin->numero_ordre))
                    @if($medecin->numero_ordre != 'null' && strlen($medecin->numero_ordre ) >0)
                        <p>Numéro d'ordre: {{$medecin->numero_ordre}}</p>
                    @endif
                @endif
            </div>
        @endif
    @endforeach
@endif
<div style="display: inline">
    @if(!is_null($praticiens->user))
        <p>Généré par <b>{{$praticiens->civilite}} {{is_null($praticiens->user->prenom) ? "" :  $praticiens->user->prenom }} {{$praticiens->user->nom}}</b></p>
        @if(!is_null($praticiens->numero_ordre))
            @if($praticiens->numero_ordre != 'null' && strlen($praticiens->numero_ordre ) >0)
                <p>Numéro d'ordre: {{$praticiens->numero_ordre}}</p>
            @endif
        @endif
    @endif
    <p style="text-align: right"> Date de création : <b>{{\Carbon\Carbon::parse()->format('d/m/Y')}}</b></p>

    @isset($signature)
        @if(!is_null($signature) && strlen($signature)>0)
            <div>
                <img  style="float: right" width="300px" height="auto" src={{public_path('/storage/'.$signature)}} />
            </div>
        @endif
    @endisset
</div>
@if(count($consultationMedecine->operationables) >0)
    <p>Contributeurs</p>
    @foreach($mContributeurs as $medecin)
        @if(!is_null($medecin->user))
            <div style="display: inline">
                @if(!is_null($medecin->signature))
                    <div>
                        <img width="300px" height="auto" src={{public_path('/storage/'.$medecin->signature)}} />
                    </div>
                @endif

                <p>{{$medecin->civilite}} {{is_null($medecin->user->prenom) ? "" :  $medecin->user->prenom }} {{$medecin->user->nom}}</p>

                @if(!is_null($medecin->numero_ordre))
                    @if($medecin->numero_ordre != 'null' && strlen($medecin->numero_ordre ) >0)
                        <p>Numéro d'ordre: {{$medecin->numero_ordre}}</p>
                    @endif
                @endif
            </div>
        @endif
    @endforeach
    @foreach($pContributeurs as $praticien)
        @if(!is_null($praticien->user))
            <div style="display: inline">
                @if(!is_null($praticien->signature))
                    <div>
                        <img width="300px" height="auto" src={{public_path('/storage/'.$praticien->signature)}} />
                    </div>
                @endif

                <p>{{$praticien->civilite}} {{is_null($praticien->user->prenom) ? "" :  $praticien->user->prenom }} {{$praticien->user->nom}}</p>

                @if(!is_null($praticien->numero_ordre))
                    @if($praticien->numero_ordre != 'null' && strlen($praticien->numero_ordre ) >0)
                        <p>Numéro d'ordre: {{$praticien->numero_ordre}}</p>
                    @endif
                @endif
            </div>
        @endif
    @endforeach
@endif

</body>
</html>
