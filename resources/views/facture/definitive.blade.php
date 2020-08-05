@extends('.rapport.layouts.rapport')

@section('body')
    @component('.rapport.slots.customEnteteEtablissement',['etablissement'=>$facture->etablissement
                                                            ,'typeDeRapport'=>"Facture définitive"])

    @endcomponent
    @component('.facture.slots.presentation',['patient'=>$facture->dossier->patient])
    @endcomponent

    @component('.facture.slots.prestation',['prestations'=>$facture->prestations])
    @endcomponent


    <h4 class="sous-titre-rapport--table">Resumé</h4>
    <p>Total hors remise: <strong>{{$facture->total_hors_remise}}</strong></p>
    <p>Remise: <strong>{{$facture->remise}}</strong></p>
    <p>Total avec remise: <strong>{{$facture->total_avec_remise}}</strong></p>

@endsection
