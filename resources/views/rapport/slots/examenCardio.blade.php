@if(count($examens) >0)
    <h4 class="sous-titre-rapport--table">Examen cardio</h4>
    <div class="divTable">
        <div class="divTableBody">
            <div class="divTableRow">

                <div class="divTableCell">
                    <table>
                        <thead>
                        <td class="title-table">Type</td>
                        <td class="title-table">Description</td>
                        <td class="title-table">Date examen</td>
                        </thead>
                        <tbody>
                        <tr></tr>
                        @foreach($examens as $examen)
                                <tr>
                                    <td>{{$examen->nom}}</td>
                                    <td>{{$examen->description}}</td>
                                    <td>{{\Carbon\Carbon::parse($examen->date_examen)->format('d/m/Y')}}</td>
                                </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endif
