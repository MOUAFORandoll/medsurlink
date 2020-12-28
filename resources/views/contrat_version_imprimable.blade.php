<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href='https://fonts.googleapis.com/css?family=Raleway:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900&display=swap' rel='stylesheet'>

{{--    <link href='https://fonts.googleapis.com/css?family=Raleway' rel='stylesheet'>--}}
{{--    <link href="{{ asset('css/app.css') }}" rel="stylesheet">--}}
    {{--    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">--}}
    {{--    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>--}}

    <title>Laravel</title>
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

<h2 class="text-center" style="text-align: center"><strong><u>Contrat d'intermediation médicale
            {{--            - {{strtoupper($cim->nomPatient)}} {{ucfirst($cim->prenomPatient)}} - {{ucfirst($cim->typeSouscription)}}--}}
        </u></strong></h2>
<br>
<p><strong>ENTRE</strong></p>
<br>
<br>
    <div style="display: inline-block; " >
        @if($cim->lieuEtablissement == 'Douala')
            <p><strong>Medsur Sarl,</strong> N° RC/DLN/2019/B/427</p>
            <p>Rue Bebe Elamé, Immeuble Mutations</p>
            <p>Akwa - BP : 4615 Douala</p>
            <p>Cameroun</p>
            <p>E-Mail: contact@medicasure.com</p>
            <p>Dénommée la Société</p>
        @else
            <p><strong>Medicasure Sprl,</strong> située Rue du Castel 18,</p>
            <p>7801 Irchonwelz, Belgique,</p>
            <p>N° d’entreprise 0725888216</p>
            <p>E-Mail : contact@medicasure.com</p>
            <p>Dénommée la Société</p>
        @endif
    </div>
    <div  style="display: inline-block; height: 255px; ">
        <p><strong>ET</strong><p>
    </div>
    <div  style="display: inline-block; height: 260px; max-height: 265px;" >
        <p><span>{{$cim->sexeSouscripteur}} </span> <span>{{$cim->nomSouscripteur}}</span></p>
        <p>Résidant à {{$cim->paysResidenceSouscripteur}} {{$cim->villeResidenceSouscripteur}}</p>
        <p>Téléphone : {{$cim->telephoneSouscripeur1}} {{$cim->telephoneSouscripeur2}}</p>
        <p>E-mail : {{$cim->emailSouscripteur1}} {{$cim->emailSouscripteur2}}</p>
        <p>Dénommé le Souscripteur</p>
    </div>
<p style="margin-top: -40px">
    S’établit le présent <strong>Contrat d’intermédiation médicale</strong> soumis aux clauses et conditions suivantes :
</p>
<p><strong>
        Article 1.
    </strong>
</p>
<p>
    Le présent Contrat a pour but d’organiser, au sein du réseau de Medicasure, la prise en charge de :
</p>

<p>Le bénéficiaire de ce contrat d’intermédiation médicale est :</p>
<p>{{$cim->sexeAffilie}}. {{$cim->nomAffilie}} </p>
<p>Âge/Date de naissance {{$cim->ageAffilie}}/{{\Carbon\Carbon::parse($cim->dateNaissanceAffilie)->format('d/m/Y')}}</p>
<p>Résidant à :{{$cim->paysResidenceAffilie}} {{$cim->villeResidenceAffilie}}</p>
<p>Téléphone du contact : {{$cim->personneContact1}}</p>

<p><strong>Article 2.</strong></p>
@if($cim->lieuEtablissement == 'Douala')
    <p>Le Souscripteur s’engage à payer les frais d’affiliation annuelle d’un montant de <strong>{{$cim->montantSouscription}} F cfa
            @if($cim->montantSouscription == 45.000)
                (Quarante-cinq milles)
            @else
                (vingt-cinq milles)
            @endif
        </strong>
        correspondant pour le bénéficiaire à :</p>
@else
    <p>Le Souscripteur s’engage à payer les frais d’affiliation annuelle d’un montant de <strong>{{$cim->montantSouscription}} EUR
            @if($cim->montantSouscription == 50)
                (Cinquante)
            @else
                (Quatre-vingt-cinq)
            @endif
        </strong>
        correspondant pour le bénéficiaire à :</p>
@endif
<br>
<p><strong>-	Création du dossier médical informatisé</strong></p>
<p><strong>-	Identification du profil médical</strong></p>
<p><strong>-	Evaluation du risque de santé liés aux plaintes</strong></p>
<p><strong>-	Contact et arrangement de la prise en charge avec les spécialistes concernés</strong></p>
<p><strong>-	Discussion pluridisciplinaire des pathologies</strong></p>
<p><strong>-	Vérification et suivi de la prise en charge effective</strong></p>
<p><strong>-	Vérification des facturations</strong></p>
<p><strong>-	Accompagnement permanent</strong></p>

<p> <strong>Article 3.</strong></p>
<p> L’ensemble des frais d’intermédiation sont payés avant la proposition d’un plan de prise en charge de l’affilié sur le compte mentionné dans l’ordre de virement.</p>

<p> <strong>Article 4</strong>.</p>
<p>Le payement des frais susmentionnés vaut acceptation de l’offre.</p>
<p><strong>Article 5.</strong></p>
<p> Le présent Contrat est régi par les conditions générales de Medicasure consultables sur le site internet www.medicasure.com</p>

<p>Fait à {{$cim->lieuEtablissement}}, le {{\Carbon\Carbon::parse($cim->dateSignature)->format('d/m/Y H:i')}}, en deux exemplaires originaux pour les deux parties.</p>
<p>Chaque partie reconnait avoir reçu au moins un exemplaire.</p>

@if($cim->paysSouscription == 'Cameroun')
    <p>Pour <strong>Medsure Sarl,</strong></p>
    <br>
    <img src="{{public_path('images/signature_kamto.png')}}" alt="Logo" width="200px" height="200px">
    <&nbsp;>
    <br>
    <br>

    <table>
        <tr color="black">
            <td colspan="3">Montant</td>
            <td>{{$cim->montantSouscription}}</td>
        </tr>
        <tr border="black 2px solid">
            <td colspan="2">Paiement Money Electronique</td>
            <td colspan="2">Paiement bancaire</td>
        </tr>
        <tr color="black">
            <td color="black"> Numéro Mobile Money</td>
            <td color="black">654447048</td>
            <td color="black">N°Compte Afriland IBAN</td>
            <td color="black">CM21 10005 00020 06031161001 44</td>
        </tr>
        <tr color="black">
            <td color="black">Nom bénéficiaire</td>
            <td color="black">Kamto Christian</td>
            <td color="black">Medsur Sarl	</td>
            <td color="black">{{$cim->nomAffilie}}</td>
        </tr>
    </table>
@else
    <p>Pour <strong>Medicasure Sprl,</strong></p>
    <br>
    <img src="{{public_path('images/signature_kamto.png')}}" alt="Logo" width="200px" height="200px">
    <&nbsp;>
    <br>
    <br>
    <table>
        <tr>
            <td>Ordre de Virement</td>
        </tr>
        <tr>
            <td>Compte bénéficiaire (IBAN)</td>
            <td><strong>BE75 0689 3376 3251</strong></td>
        </tr>
        <tr>
            <td>BIC bénéficiaire</td>
            <td><strong>GKCCBEBB</strong></td>
        </tr>
        <tr>
            <td>Nom</td>
            <td>Medicasure SPRL</td>
        </tr>
        <tr>
            <td>Adresse bénéficiaire</td>
            <td>Rue du Castel 18, 7801 Irchonwelz - Belgique</td>
        </tr>
        <tr>
            <td>Communication</td>
            <td>(Affiliation Medicasure) - {{$cim->nomAffilie}}</td>
        </tr>
    </table>
@endif

</body>
</html>
