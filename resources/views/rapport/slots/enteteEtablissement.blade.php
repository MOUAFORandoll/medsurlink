@if(!is_null($etablissement))
    <div>
        @if(!is_null($etablissement->logo) && $etablissement->logo !=='')
            <div class="rapport-logo-wrapper">
                <img src="{{public_path('/storage/'.$etablissement->logo)}}" class="logo-rapport" alt="" />
            </div>
        @endif
        <p style="text-align: center"><b>{{$etablissement->name}}</b></p>
        <p class="titre-rapport"><strong>Rapport de consultation</strong></p>
        <br>
    </div>
@endif
