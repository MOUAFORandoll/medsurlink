@php
    use Carbon\Carbon;
@endphp
@extends('pdf.layouts.pdf', ['format' => $format])
@section('title', "Prescription des médicaments de {$patient->user->name } du {$date} par {$medecin->civilite} {$medecin->user->name}")
@section('content')
    <div class="content mt-2">
        <h1 class="mt-2">Prescription des médicaments</h1>
    </div>
    <div id="content" class="default-margin">
        @include('pdf.includes.identification_patient', ['patient' => $patient])
        <div class="content" style="{{ $format == 'a6' ? '2%' : '5%' }};">
            @if (count($prescription['medicaments'])>0)
                <legend class="legend-list"><b>Liste des médicaments</b></legend>

                @if (count($prescription['medicaments'])>0)
                    <table>
                        <thead>
                            <tr>
                                <th class="text-center">N°</th>
                                <th>Médicaments</th>
                                <th>Posologies</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($prescription['medicaments'] as $medicament)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $medicament['denomination'] }}</td>
                                    <td>  {{ $medicament['pivot']['quantite_lors_une_prise'] }} {{ $medicament['unite_presentation']['libelle'] }}(s) {{ $medicament['pivot']['nombre_de_prise'] }} fois tout les {{ $medicament['pivot']['nombre_de_fois'] }} heure(s) pendant {{ $medicament['pivot']['duree_traitement'] }} jour(s)
                                        (
                                            @forelse ($medicament['horaire_de_prises']  as $horaire_de_prise)
                                                {{ $horaire_de_prise['libelle'] }}
                                                @if(!$loop->last)
                                                    {{", "}}
                                                @endif
                                            @empty
                                            @endforelse
                                        )
                                        @if($medicament['pivot']['nombre_renouvelement'] > 1)
                                            renouvelable {{ $medicament['pivot']['nombre_renouvelement'] }} fois. <br>
                                        @endif
                                        <b>Unité d'achat</b> : {{ $medicament['pivot']['nombre_unite_achat'] }} {{ $medicament['conditionnement']['libelle'] }}(s)
                                    </td>
                                </tr>
                            @empty
                            @endforelse
                        </tbody>
                    </table>
                @endif
            @endif
            <div class="content-text mt-1">
                {!! $format == 'a6' ? '' : ' <br>' !!}
                <p style="font-size: {{$format == 'a6' ? '9px' : '10px'}};"><b><i>NB : Merci de recontacter le prescripteur rapidement en cas d'aggravation des symptômes</i></b></p>
            </div>
            @include('pdf.includes.signature_medecin', ['medecin' => $medecin, 'format' => 'a4'])
        </div>
    </div>
@endsection

