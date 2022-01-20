@if(!is_null($date) && $date != 'null' )
    <h4 class="sous-titre-rapport">Date de rendez vous</h4>
    @if($date != 'null')
        <p>{{\Carbon\Carbon::parse($date)->format('d/m/Y')}}</p>
    @endif
@endif
