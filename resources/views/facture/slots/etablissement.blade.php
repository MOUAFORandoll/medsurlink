@if(!is_null($etablissement))
    <div style="display: table;width:100%">
        <div style="display: table-row">
            @if(!is_null($etablissement->logo))
                <div class="rapport-logo-wrapper" style="display: table-cell; width: 20%" >
                    <img src="{{public_path('/storage/'.$etablissement->logo)}}" class="logo-rapport" alt="" />
                </div>
            @endif
            @if(!is_null($etablissement->logo))
                <div style="display: table-cell; width: 100%; ">
            @else
                <div style="width: 100%">
            @endif
                            <p style="text-align: center"><b>{{$etablissement->name}}</b></p>
                            <p style="text-align: center"><strong>{{$etablissement->adresse}}</strong></p>
                            <br>
                        </div>
                </div>
        </div>
@endif
