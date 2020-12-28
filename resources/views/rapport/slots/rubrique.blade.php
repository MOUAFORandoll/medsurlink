@if(!is_null($valeur) && $valeur != 'null' )
<div class="rubrique ">
    <div class="rubrique-title page-break ">
       <h4 class="" >{{$titre}}</h4>
    </div>
    @if($valeur != 'null')
        <p>{!!$valeur!!}</p>
    @endif
</div>
@endif
