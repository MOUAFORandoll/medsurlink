@if(count($prestations) >0)
    <h4 class="sous-titre-rapport--table" style="margin-top: 90px">Prestations</h4>
    <div class="divTable" style="margin-bottom: 90px;">
        <div class="divTableBody">
            <div class="divTableRow">

                <div class="divTableCell">
                    <table style="width: 100%; margin: 0px -9px">
                        <thead>
                        <td class="title-table">Description</td>
                        <td class="title-table">Date de prestation</td>
                        <td class="title-table">Quantité</td>
                        <td class="title-table">PU TTC</td>
                        <td class="title-table">PT TTC</td>
                        </thead>
                        <tbody>
                        <tr></tr>
                        @forelse($prestations as $prestation)
                            <tr>
                                <td>{{$prestation->prestation_etablissement->prestation->nom}}</td>
                                <td>{{\Carbon\Carbon::parse($prestation->date_prestation)->format('d/m/Y')}}</td>
                                <td>1</td>
                                <td>{{$prestation->prestation_etablissement->prix}}</td>
                                <td>{{$prestation->prestation_etablissement->prix}}</td>
                            </tr>
                        @empty
                            <strong></strong>
                        @endforelse
                        <tr class="noBorder"><td class="noBorder" colspan="5"></tr>
                        <tr class="noBorder"><td class="noBorder" colspan="5"></tr>
                        <tr>
                            <td class="title-table" colspan="4">Total à payer</td>
                            <td colspan="2">{{$facture->total_avec_remise}} F CFA</td>
                        </tr>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
@endif
