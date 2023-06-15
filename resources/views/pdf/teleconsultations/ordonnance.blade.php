@php
    use Carbon\Carbon;
@endphp
@extends('pdf.layouts.pdf', ['format' => 'a4'])
@section('title', "Ordonnance de {$patient->user->name } du {$date} par {$medecin->civilite} {$medecin->user->name}")
@section('content')
  <div id="content" class="default-margin">
    <div class="content mt-2">
        <h1 class="mt-2">Ordonnance</h1>
    </div>
        <div class="content">
            @include('pdf.includes.identification_patient', ['patient' => $patient])
            @if($ordonnance['description'] != "")
                <fieldset class="content-field mt-2">
                    <legend>Prescription</legend>
                    {!! $ordonnance['description'] !!}
                </fieldset>
            @endif
            @include('pdf.includes.signature_medecin', ['medecin' => $medecin, 'format' => 'a4'])
        </div>
  </div>
@endsection




