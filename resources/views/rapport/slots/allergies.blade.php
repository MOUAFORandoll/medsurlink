<h4 class="sous-titre-rapport--table">Allergies</h4>
<div class="divTable">
    <div class="divTableBody">
        <div class="divTableRow">

            <div class="divTableCell">
                <table>
                    <thead>
                    <td class="title-table">Description</td>
                    </thead>
                    <tbody>
                    <tr></tr>
                    @forelse($allergies as $allergie)
                        <tr>
                            <td>{{$allergie->description}}</td>
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
