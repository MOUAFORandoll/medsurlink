@if(!is_object(collect($conclusions->toArray())->first()))
    @if(!is_null($conclusions->first()))
        <h4 class="sous-titre-rapport">Diagnostic</h4>
        <p>{!!($conclusions->first())->description!!}</p>
    @endif
@endif
