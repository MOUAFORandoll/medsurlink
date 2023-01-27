<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,400i,500,500i,600,700,800,900&display=swap" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Raleway:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900&display=swap' rel='stylesheet'>

    <title>Téléconsultation de {{ $patient->user->name }} du {{ $date }} par {{ $medecin->civilite }} {{ $medecin->user->name }}</title>

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
            font-size: 12px;
        }
        .p{
            font-size: 12px;
        }
    </style>
</head>
<body>

    <div class="justify-content-center">
        <h2>Berthold feujo</h2>
        <h3>12 janvier 2023</h3>
        <h3>Sexe : Masculin</h3>
    </div>

        <div class="justify-content-center"> Allergies Information </div>
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
        </table>


    <div style="color: black">
        <div>
            <div class="rapport-logo-wrapper">
                <img src="{{public_path('/images/logo.png')}}" class="logo-rapport" alt="" />
            </div>
            <p style="text-align: center"><b>Réseau Médicasure</b></p>
        </div>
        <p class="titre-rapport"><strong>Rapport de consultation</strong></p>
        <br>
        <p>Honorée Consoeur, Honoré Confrère,</p>
        <p>J'ai vu en date du <strong>20 Janvier 2023</strong>, pour une consultation de<b> médecine générale</b>, votre patient(e)
            <strong>Berthold FEUJO</strong> né(e) le <strong>20/10/2019</strong>
            pour: mal au vendre, à la tête, au pied
        </p>.

        <h4 class="sous-titre-rapport">Motif(s) de Consultation</h4>
        <p>Motif de téléconsultation 1</p>
        <p>Motif de téléconsultation 2</p>
        <p>Motif de téléconsultation 3</p>
        <p>Motif de téléconsultation 4</p>

        <h4 class="sous-titre-rapport">Mode de vie</h4>
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
        </div>
        <h4 class="sous-titre-rapport">Antédédents</h4>
        <div class="divTable">
                <div class="divTableBody">
                    <div class="divTableRow">

                        <div class="divTableCell">
                            <table style="width: 100%">
                                <thead>
                                    <td class="title-table">Type</td>
                                    <td class="title-table">Description</td>
                                    <td class="title-table">Date debut</td>
                                </thead>
                                <tbody>
                                <tr></tr>
                                    <tr>
                                        <td>TYpe</td>
                                        <td>Description</td>
                                        <td>20/12/2022</td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
        </div>
        <h4 class="sous-titre-rapport">Parametres</h4>
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
        </div>
    </div>

    <h4 class="sous-titre-rapport">Allergies</h4>
    <span> au miel, jksd sdklsd dskl, dsklsdklsd klsdklds, dskkldskl</span>

    <div class="divTable">
        <h4 class="sous-titre-rapport">Traitement actuel</h4>
        <div class="divTableBody">
            <div class="divTableRow">
                <div>
                    <span>sdjkjkfsjksf sfjkfsjksf sfjksf fsksfk</span>
                </div>
                <div>
                    <span>sdjkjkfsjksf sfjkfsjksf sfjksf fsksfk</span>
                </div>
            </div>
        </div>
    </div>

    <h4 class="sous-titre-rapport">Anamnèse</h4>
    <div class="row">
        <div class="column">1</div>
        <div class="column">
            <span class="p">Anamnèse liste -</span>

        </div>
    </div>
    <div class="row">
        Description de l'anamnèse
    </div>

    <h4 class="sous-titre-rapport">Examen(s) clinique(s)</h4>
    <div class="row">
        <div class="column">1</div>
        <div class="column">
            <span class="p">Examen(s) clinique liste -</span>
        </div>
    </div>
    <div class="row">
        Examen(s) clinique description
    </div>

    <h4 class="sous-titre-rapport">Examen(s) complémentaire(s)</h4>
    <div class="row">
        <div class="column">1</div>
        <div class="column">
            <span class="p">ksdklklsd sdkdsm -</span>
        </div>
    </div>
    <div class="row">
        Description des examens complémentaires
    </div>

    <h4 class="sous-titre-rapport">Diagnostic ICD</h4>
    <div class="row">
        <div class="column" style="width: 20%">Code ICD</div>
        <div class="column" style="width: 80%"><p class="p">Diagnotic code</p></div>
    </div>
    <div class="row">
        <h4 class="sous-titre-rapport">Diagnostic</h4>
        <p class="p">Liste des éléments du diagnotic</p>

        <h4 class="sous-titre-rapport">Conduite à tenir</h4>
        <p>Conduite à tenir</p>
        <h4 class="sous-titre-rapport">Consulter les pièces jointes</h4>
        <a href="#">télécharger les pièces</a><br>
        <a href="#">télécharger des autres pièces</a><br>
    </div>


    <h4></h4>
    <p>Je vous remercie de m'avoir adressé votre patient(e) et vous adresse mes salutations confraternelles.</p>
    <p><i>Dossier relu et validé par l'équipe Medicasure</i></p>


    <h4 class="sous-titre-rapport">Medecin(s) ayant revisité votre consultation</h4>
    <div style="display: inline">
        <div>
            {{-- <img width="300px" height="auto" src={{public_path('/storage/'.$medecin->signature)}} /> --}}
            image signature
        </div>

        <p>Dr. Charly KADJI</p>
        <p>Numéro d'ordre: 168287</p>
    </div>

    <div style="display: inline">
        <p>Généré par <b>Dr. Charly KADJI</b></p>
        <p>Numéro d'ordre: 17898</p>
        <p style="text-align: right"> Date de création : <b>{{\Carbon\Carbon::parse()->format('d/m/Y')}}</b></p>

        <div>
            {{-- <img  style="float: right" width="300px" height="auto" src={{public_path('/storage/'.$signature)}} /> --}}
            image signature
        </div>
    </div>

    <h4 class="sous-titre-rapport">Contributeurs</h4>

    <div style="display: inline">
        <div>
            {{-- <img width="300px" height="auto" src={{public_path('/storage/'.$medecin->signature)}} /> --}}
            image signature
        </div>
        <p>Dr. TESSA</p>
        <p>Numéro d'ordre: 86856797</p>
    </div>
    <div style="display: inline">
        <div>
           {{--  <img width="300px" height="auto" src={{public_path('/storage/'.$praticien->signature)}} /> --}}
           image signature
        </div>

        <p>Dr. KAMDEM JULLES</p>
        <p>Numéro d'ordre: 189688</p>
    </div>

</body>
</html>
