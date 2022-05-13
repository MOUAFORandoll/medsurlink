@extends('.rapport.layouts.rapport')

@section('body')
@component('.facture.slots.etablissement',['etablissement'=>$facture->etablissement
                                                            ,'typeDeRapport'=>"Facture définitive"])

    @endcomponent
    <table style="width: 100%" cellspacing="0" cellpadding="0" >
        <tr class="noBorder">
            <td class="noBorder" rowspan="2" style="width: 50%" valign="top">
                <p>Date de la Facture : {{\Carbon\Carbon::parse($facture->date_facturation)->format('d/m/Y')}}</p>
                <p>Référence : {{substr($facture->etablissement->name,0,3)}}/{{date('Y')}}/{{strtolower(substr(base64_encode(md5(microtime())),0,2))}}/{{rand(1000,10000)}}</p>
                @if(!is_null($facture->createur))
                 <p>Facture émise par : {{\Illuminate\Support\Str::contains($facture->createur->email,'@medicasure') ? 'Medicasure' : 'Prestataire'}}.</p>
                @else
                         Facture émise par : Medicasure
                @endif
            </td>
            <td class="noBorder "></td>
            <td class="noBorder" valign="top" style="width: 50%; padding-top: 23px; padding-left: 50px">Numéro de Facture : {{date('Y')}}/{{$facture->etablissement_id}}{{$facture->id}}</td>
        </tr>
        <tr>
            <td class="noBorder"></td>
            <td class="noBorder" style="width: 50%; padding-top:-35px; padding-left: 50px" valign="top">
                <p>Client : {{strtoupper($facture->dossier->patient->user->nom)}} {{ucfirst($facture->dossier->patient->user->prenom)}}</p>
                <p>{{$facture->dossier->patient->user->telephone}}</p>
            </td>

        </tr>
    </table>
    @component('.facture.slots.prestation_avis',['prestations'=>$facture->factureDetail,'facture'=>$facture,'total'=>$total])
    @endcomponent

    <table style="width: 100%;" cellspacing="0" cellpadding="0" >
        <tr>
            <td>Communication</td>
            <td>{{date('Y')}}/{{$facture->etablissement_id}}{{$facture->id}}</td>
        </tr>
    </table>

    <table style="width: 100%; " cellspacing="0" cellpadding="0" >
        <tr>
            <td valign="top"> <p>Moyen de paiement</p>
                <p>{{$facture->etablissement->name}}</p>
            </td>
            <td valign="top"><p>N° compte UBA (IBAN)</p>
                <p>CM21 10033 05201 01011001676 11</p>
                <p>OM : #150*47*382085# </p>
                <p>MOMO: 00 237 674 411 042</p>
            </td>
        </tr>
    </table>
    <p style="position: absolute; bottom: 0px; left: 0px">Logiciel de Facturation médicale by Medsurlink</p>
@endsection
