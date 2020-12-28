<div style="display: inline">
    @if(!is_null($generateur->user))
        <p>Généré par <b>{{$generateur->civilite}} {{is_null($generateur->user->prenom) ? "" :  $generateur->user->prenom }} {{$generateur->user->nom}}</b></p>
        @if(!is_null($generateur->numero_ordre))
            @if($generateur->numero_ordre != 'null' && strlen($generateur->numero_ordre ) >0)
                <p>Numéro d'ordre: {{$generateur->numero_ordre}}</p>
            @endif
        @endif
    @endif
    <p style="text-align: right"> Date de création : <b>{{\Carbon\Carbon::parse()->format('d/m/Y')}}</b></p>

    @isset($generateur->signature)
        @if(!is_null($generateur->signature) && strlen($generateur->signature)>0)
            <div>
                <img  style="float: right" width="300px" height="auto" src={{public_path('/storage/'.$generateur->signature)}} />
            </div>
        @endif
    @endisset
</div>
