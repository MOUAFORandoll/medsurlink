<table style="width:100%; border-collapse:collapse; border: 0px solid;">
    <tr>
        <td style="text-align:left; border:none; color: #32325d;">
            <p>
                <strong>{{ $medecin->civilite ?? '' }}  {{ $medecin->user->name }}</strong><br />
                Numéro d’ordre : {{ $medecin->numero_ordre }}<br />
                {!! $format == 'a6' ? '' : ' <br>' !!}
                Fait le {{ $date }}
            </p>
        </td>
        <td style="text-align:right; border:none; color: #32325d;">
            @isset(explode('storage', $medecin->user->signature)[1])
                <img style="{{ $format == 'a6' ? 'width: 100px' : 'width: 250px' }};"  src="{{ public_path('/storage/'.explode('storage', $medecin->user->signature)[1]) }}" />
            @endisset
        </td>
    </tr>
</table>