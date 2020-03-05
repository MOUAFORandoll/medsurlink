@if(!is_null($examen) )
    <h4 class="sous-titre-rapport">{{$titre}}</h4>
    @if($examen != 'null')
        <p>{!!$examen!!}</p>
    @endif
@endif
