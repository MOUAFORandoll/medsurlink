@php
    use Carbon\Carbon;
@endphp
@extends('pdf.layouts.pdf')
@section('title', "Prescription imageries de {$patient->user->name } du {$date} par {$medecin->civilite} {$medecin->user->name}")
@section('content')
  <div id="content" class="default-margin">
    @include('pdf.includes.identification_patient', ['patient' => $patient])
    <div class="content mt-2">
        <h1>Prescription imageries</h1>

    @if(count($prescription_imagerie['etablissements']) > 0)
        <fieldset class="content-field mt-2">
            <legend>Etablissement</legend>
            <p>{{ $prescription_imagerie['etablissements'][0]['name'] }}</p>
        </fieldset>
    @endif

    @if($prescription_imagerie['information_clinique'])
        <fieldset class="content-field mt-2">
            <legend>Informations cliniques pertinentes</legend>
            <p>{{ $prescription_imagerie['information_clinique'] }}</p>
        </fieldset>
    @endif

    @if($prescription_imagerie['explication_demande_diagnostic'])
        <fieldset class="content-field mt-2">
            <legend>Explication de la demande de diagnostic</legend>
            <p>{{ $prescription_imagerie['explication_demande_diagnostic'] }}</p>
        </fieldset>
    @endif


    @if(count($prescription_imagerie['information_supplementaires']) > 0)
        <fieldset class="content-field mt-2">
            <legend>Informations supplémentaires pertinentes</legend>
            <ol>
                @forelse ($prescription_imagerie['information_supplementaires'] as $information)
                    <li>{{ $information['libelle'] }}</li>
                @empty
                @endforelse
            </ol>
        </fieldset>
    @endif



    @if (count($prescription_imagerie['examen_complementaires'])>0)
        <fieldset class="content-field mt-2">
            <legend>Examens à réaliser</legend>

            @if (count($prescription_imagerie['examen_complementaires'])>0)
                <table>
                    <thead>
                        <tr>
                            <th>#</th><th>Catégories</th><th>Examens</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($prescription_imagerie['type_examens'] as $type_examen)
                            <tr>
                                <td rowspan="{{ count($type_examen['examen_complementaires']) }}">{{ $loop->iteration }}</td>
                                <td rowspan="{{ count($type_examen['examen_complementaires']) }}">{{ $type_examen['libelle'] }}</td>
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
    @endif

    @if(count($prescription_imagerie['examens_pertinents']) > 0)
        <fieldset class="content-field mt-2">
            <legend>Examens pertinents précédents relatifs à la demande de diagnostic</legend>
            <ol>
                @forelse ($prescription_imagerie['examens_pertinents'] as $examens_pertinent)
                    <li>{{ $examens_pertinent['libelle'] }}</li>
                @empty
                @endforelse
            </ol>
        </fieldset>
    @endif

      @include('pdf.includes.signature_medecin', ['medecin' => $medecin])
    </div>
  </div>
@endsection



