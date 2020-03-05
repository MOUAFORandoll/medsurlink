@if(strlen($conduite)>0)
    <h4 class="sous-titre-rapport">Conduite à tenir</h4>
    @if($conduite != 'null')
        <p>{!! $conduite !!}</p>
    @endif
@endif
