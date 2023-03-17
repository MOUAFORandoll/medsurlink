<div class="content-text">
    <p>
      <strong>{{ $medecin->civilite ?? '' }}  {{ $medecin->user->name }}</strong><br />
      Numéro d’ordre : {{ $medecin->numero_ordre }}<br />
      Téléphone : {{ number_format($medecin->user->telephone, 0,","," ")  }}<br />
      Date de prescription : {{ $date }}
    </p>
    @isset(explode('storage', $medecin->user->signature)[1])
        <div>
            <img style="width: 270px;"  src="{{ public_path('/storage/'.explode('storage', $medecin->user->signature)[1]) }}" />
        </div>
    @endisset
</div>
