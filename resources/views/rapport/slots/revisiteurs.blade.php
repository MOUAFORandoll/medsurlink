@if(count($medecins) != 0)
    <h4>Medecin(s) ayant revisité votre consultation</h4>
    @foreach($medecins as $medecin)
        @if(!is_null($medecin->user))
            <div style="display: inline">
                @if(!is_null($medecin->signature))
                    <div>
                        <img width="300px" height="auto" src={{public_path('/storage/'.$medecin->signature)}} />
                    </div>
                @endif

                <p>{{$medecin->civilite}} {{is_null($medecin->user->prenom) ? "" :  $medecin->user->prenom }} {{$medecin->user->nom}}</p>

                @if(!is_null($medecin->numero_ordre))
                    @if($medecin->numero_ordre != 'null' && strlen($medecin->numero_ordre ) >0)
                        <p>Numéro d'ordre: {{$medecin->numero_ordre}}</p>
                    @endif
                @endif
            </div>
        @endif
    @endforeach
@endif
