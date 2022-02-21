@if(!is_null($valeur) && $valeur != 'null' )
    <h4 class="sous-titre-rapport">{{$titre}}</h4>
    @if($valeur != 'null')
        <p>{!!$valeur!!}</p>
    @endif
@endif
