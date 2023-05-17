@php
    use Carbon\Carbon;
@endphp
@extends('pdf.layouts.pdf', ['format' => 'a4'])
@section('title', "Bulletin d'examens d'analyses biomédicales de {$patient->user->name } du {$date} par {$medecin->civilite} {$medecin->user->name}")
@section('content')
  <div id="content" class="default-margin">
    <div class="content mt-2">
        <h1 class="mt-2">Bulletin d'examens d'analyses biomédicales</h1>
    </div>
    @include('pdf.includes.identification_patient', ['patient' => $patient])
    <div class="content mt-2">
    @if(count($examen_analyse['etablissements']) > 0)
        <fieldset class="content-field">
            <legend>Etablissement</legend>
            <p>{{ $examen_analyse['etablissements'][0]['name'] }}</p>
        </fieldset>
    @endif

    <fieldset class="content-field mt-1">
        <legend>Renseignement clinique</legend>
        {!! $examen_analyse['renseignement_clinique'] !!}
    </fieldset>

    <fieldset class="content-field mt-1">
        <legend>Examens à réaliser</legend>

        @if (count($examen_analyse['examen_complementaires'])>0)
            <table>
                <thead>
                    <tr>
                        <th>N°</th><th>Catégories</th><th>Examens</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($examen_analyse['type_examens'] as $type_examen)
                        <tr>
                            <td rowspan="{{ count($type_examen['examen_complementaires']) }}">{{ $loop->iteration }}</td>
                            <td rowspan="{{ count($type_examen['examen_complementaires']) }}">{{ $type_examen['description'] }}</td>
                            @forelse ($type_examen['examen_complementaires'] as $item)
                                <td>{{ $item['fr_description'] }}</td></tr>
                                @if(!$loop->last)
                                    <tr>
                                @endif
                            @empty
                            @endforelse
                        </tr>
                    @empty
                    @endforelse
                </tbody>
            </table>
        @endif
    </fieldset>

      @include('pdf.includes.signature_medecin', ['medecin' => $medecin])
    </div>
  </div>
@endsection


