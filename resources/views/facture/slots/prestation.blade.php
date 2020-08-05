@if(count($prestations) >0)
    <h4 class="sous-titre-rapport--table">Prestations</h4>
    <div class="divTable">
        <div class="divTableBody">
            <div class="divTableRow">

                <div class="divTableCell">
                    <table>
                        <thead>
                        <td class="title-table">Nom</td>
                        <td class="title-table">Prix (F CFA)</td>
                        <td class="title-table">Date</td>
                        </thead>
                        <tbody>
                        <tr></tr>
                        @forelse($prestations as $prestation)
                            <tr>
                                <td>{{$prestation->prestation_etablissement->prestation->nom}}</td>
                                <td>{{$prestation->prestation_etablissement->prix}}</td>
                                <td>{{\Carbon\Carbon::parse($prestation->date_prestation)->format('d/m/Y')}}</td>
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
