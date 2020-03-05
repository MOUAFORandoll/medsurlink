 <h4 class="sous-titre-rapport--table">Traitement actuel</h4>
        <table>
            <thead>
            <td class="title-table">Description</td>
            <td class="title-table">Date prescription</td>
            </thead>
            <tbody>
            <tr></tr>
            @foreach($traitements as $traiement)
                @if($loop->last)
                    <tr>
                        <td>{{$traiement->description}}</td>
                        <td>{{\Carbon\Carbon::parse($traiement->created_at)->format('d/m/Y')}}</td>
                    </tr>
                @endif
            @endforeach
            </tbody>
        </table>
