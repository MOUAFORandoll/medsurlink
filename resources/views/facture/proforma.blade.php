@extends('.rapport.layouts.rapport')

@section('body')
    @component('.facture.slots.etablissement',['etablissement'=>$facture->etablissement
                                                            ,'typeDeRapport'=>"Facture définitive"])

    @endcomponent
    <table style="width: 100%" cellspacing="0" cellpadding="0" >
        <tr class="noBorder">
            <td class="noBorder" rowspan="2" style="width: 50%" valign="top">
                <p>Date de la Facture : {{\Carbon\Carbon::parse($facture->date_facturation)->format('d/m/Y')}}</p>
{{--                <p>Référence : {{strtolower(substr($facture->etablissement->name,0,3))}}/{{date('Y')}}/{{strtolower(substr(base64_encode(md5(microtime())),0,2))}}/{{rand(1000,10000)}}</p>--}}
                <p>PRO-FORMA émise par : {{\Illuminate\Support\Str::contains($facture->createur->email,'@medicasure') ? 'Medicasure' : 'Prestataire'}}.
            </td>
            <td class="noBorder "></td>
            <td class="noBorder" valign="top" style="width: 50%; padding-top: 23px; padding-left: 50px">Numéro de Facture : {{date('Y')}}/{{$facture->etablissement_id}}{{$facture->id}}</td>
        </tr>
        <tr>
            <td class="noBorder"></td>
            <td class="noBorder" style="width: 50%; padding-top:-10px; padding-left: 50px" valign="top">
                <p>Client : {{strtoupper($facture->dossier->patient->user->nom)}} {{ucfirst($facture->dossier->patient->user->prenom)}}</p>
                <p>{{$facture->dossier->patient->user->telephone}}</p>
            </td>


        </tr>
    </table>

    @component('.facture.slots.prestation',['prestations'=>$facture->prestations,'facture'=>$facture])
    @endcomponent

{{--    <table style="width: 100%;" cellspacing="0" cellpadding="0" >--}}
{{--        <tr>--}}
{{--            <td>Communication</td>--}}
{{--            <td>{{date('Y')}}/{{$facture->etablissement_id}}{{$facture->id}}</td>--}}
{{--        </tr>--}}
{{--    </table>--}}

{{--    <table style="width: 100%; " cellspacing="0" cellpadding="0" >--}}
{{--        <tr>--}}
{{--            <td valign="top"> <p>Moyen de paiement</p>--}}
{{--                <p>{{$facture->etablissement->name}}</p>--}}
{{--            </td>--}}
{{--            <td valign="top"><p>N° compte Afriland (IBAN) </p>--}}
{{--                <p>CM21 10005 00020 06031161001 44</p>--}}
{{--                <p>OM : 00 237 674 411 042 </p>--}}
{{--                <p>MOMO: 00 237 674 411 042</p>--}}
{{--            </td>--}}
{{--        </tr>--}}
{{--    </table>--}}
    <p style="position: absolute; bottom: 0px; left: 0px">Logiciel de Facturation médicale by Medsurlink</p>
@endsection
