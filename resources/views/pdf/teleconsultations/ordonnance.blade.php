@php
    use Carbon\Carbon;
@endphp
@extends('pdf.layouts.pdf')
@section('title', "Ordonnance de {$patient->user->name } du {$date} par {$medecin->civilite} {$medecin->user->name}")
@section('content')
  <div id="content" class="default-margin">
        @include('pdf.includes.identification_patient', ['patient' => $patient])
        <div class="content mt-2">
            <h1>Ordonnance</h1>
            @if($ordonnance['description'] != "")
                <fieldset class="content-field mt-2">
                    <legend>Prescription</legend>
                    {!! $ordonnance['description'] !!}
                </fieldset>
            @endif
            @include('pdf.includes.signature_medecin', ['medecin' => $medecin])
        </div>
  </div>
@endsection




