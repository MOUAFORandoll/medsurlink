 @if(count($traitements) >0)
 <h4 class="sous-titre-rapport--table">Traitement actuel</h4>
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
            @foreach($traitements as $traiement)
                @if($loop->last)
                    <tr>
                        <td>{{$traiement->description}}</td>
                    </tr>
                @endif
            @endforeach
            </tbody>
        </table>
       </div>
      </div>
                </div>
            </div>
            @endif
