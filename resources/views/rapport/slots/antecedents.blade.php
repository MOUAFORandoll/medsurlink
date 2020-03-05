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
                    @forelse($antecedents as $antecedent)
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

            </div>
        </div>
    </div>
</div>
