@if(count($consultationMedecine->operationables) >0)
    <p>Contributeurs</p>
    @foreach($consultationMedecine->operationables as $operationable)
        @if(!is_null($operationable->contributable))
            <div style="display: inline">
                @if(!is_null($operationable->contributable->praticien))
                    @if(!is_null($operationable->contributable->praticien->signature))
                        <div>
                            <img width="300px" height="auto" src={{public_path('/storage/'.$operationable->contributable->praticien->signature)}} />
                        </div>
                    @endif
                    <p>{{$operationable->contributable->praticien->civilite}} {{is_null($operationable->contributable->prenom) ? "" :  $operationable->contributable->prenom }} {{$operationable->contributable->nom}}</p>

                    @if(!is_null($operationable->contributable->praticien->numero_ordre))
                        @if($operationable->contributable->praticien->numero_ordre != 'null' && strlen($operationable->contributable->praticien->numero_ordre ) >0)
                            <p>Numéro d'ordre: {{$operationable->contributable->praticien->numero_ordre}}</p>
                        @endif
                    @endif
                @elseif(!is_null($operationable->contributable->medecinControle))
                    @if(!is_null($operationable->contributable->medecinControle->signature))
                        <div>
                            <img width="300px" height="auto" src={{public_path('/storage/'.$operationable->contributable->medecinControle->signature)}} />
                        </div>
                    @endif
                    <p>{{$operationable->contributable->medecinControle->civilite}} {{is_null($operationable->contributable->prenom) ? "" :  $operationable->contributable->prenom }} {{$operationable->contributable->nom}}</p>

                    @if(!is_null($operationable->contributable->medecinControle->numero_ordre))
                        @if($operationable->contributable->medecinControle->numero_ordre != 'null' && strlen($operationable->contributable->medecinControle->numero_ordre ) >0)
                            <p>Numéro d'ordre: {{$operationable->contributable->medecinControle->numero_ordre}}</p>
                        @endif
                    @endif
                @endif
            </div>
        @endif
    @endforeach

@endif
