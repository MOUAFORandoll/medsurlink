@php
    use Carbon\Carbon;
@endphp
@extends('pdf.layouts.pdf', ['format' => 'a4'])
@section('title', "Rapport de téléconsultation de {$patient->user->name } du {$date} par {$medecin->civilite} {$medecin->user->name}")
@section('content')
    <div class="content mt-2">
        <h1 class="mt-2">Rapport de téléconsultation</h1>
    </div>
    <div id="content" class="default-margin">
        @include('pdf.includes.identification_patient', ['patient' => $patient])
        <div class="content">
            <div class="content-text mt-2">
                <p>Honorée Consoeur, Honoré Confrère,</p>
                <p>J'ai vu en date du <strong>{{ Carbon::parse($teleconsultation["created_at"])->locale(config('app.locale'))->translatedFormat('jS F Y') }}</strong>, pour une téléconsultation médicale de type <b> {{ $teleconsultation['type']['libelle'] }}</b>, votre patient(e)
                    <strong>{{ $patient->user->name }}</strong> né(e) le <strong> {{ Carbon::parse($patient->date_de_naissance)->locale(config('app.locale'))->translatedFormat('jS F Y') }} </strong>
                    pour:  @forelse ($teleconsultation['motifs'] as $motif)
                                {{ $motif['description'] }}
                                @if(!$loop->last)
                                {{", "}}
                                @else
                                {{"."}}
                                @endif
                            @empty 
                            @endforelse
                </p>.
            </div>

            @if(count($teleconsultation['motifs']) > 0)
                <fieldset class="content-field mt-1">
                    <legend>Informations supplémentaires pertinentes</legend>
                    <ol>
                        @forelse ($teleconsultation['motifs'] as $motif)
                            <li>{{ $motif['description'] }}</li>
                        @empty
                        @endforelse
                    </ol>
                </fieldset>
            @endif

            @if (count($teleconsultation['antededents'])>0)
                <fieldset class="content-field mt-1">
                    <legend>Liste des médicaments</legend>
                    @if (count($teleconsultation['antededents'])>0)
                        <table>
                            <thead>
                                <tr>
                                    <th>Type</th>
                                    <th>Description</th>
                                    <th>Date début</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($teleconsultation['antededents'] as $antededent)
                                    <tr>
                                        <td>{{ $antededent['type']['libelle'] }}</td>
                                        <td>{!! $antededent['description'] !!}</td>
                                        <td>{{ $antededent['date'] }}</td>
                                    </tr>
                                @empty
                                @endforelse
                            </tbody>
                        </table>
                    @endif
                </fieldset>
            @endif

            @if(count($teleconsultation['allergies']) > 0)
                <fieldset class="content-field mt-1">
                    <legend>Allergies</legend>
                    <ol>
                        @forelse ($teleconsultation['allergies'] as $allergie)
                            {!! $allergie['description'] !!}
                            @if(!$loop->last)
                            {{", "}}
                            @else
                            {{"."}}
                        @endif
                        @empty
                        @endforelse
                    </ol>
                </fieldset>
            @endif


            @if (count($teleconsultation['anamneses'])>0)
                <fieldset class="content-field mt-1">
                    <legend>Anamnèses</legend>
                    @if (count($teleconsultation['anamneses'])>0)
                        <table>
                            <thead>
                                <tr>
                                    <th>Nom</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($teleconsultation['anamneses'] as $anamnese)
                                    <tr>
                                        <td>
                                            {!! $anamnese['fr_description'] !!} <br>
                                            Description: {!! isset(json_decode($anamnese['pivot']['data'])->anamnese) ? json_decode($anamnese['pivot']['data'])->anamnese : '' !!}
                                        </td>
                                    </tr>
                                @empty
                                @endforelse
                            </tbody>
                        </table>
                    @endif
                </fieldset>
            @endif

            @if(count($teleconsultation['examen_cliniques']) > 0)
                <fieldset class="content-field mt-1">
                    <legend>Examen(s) clinique(s)</legend>
                    <ol>
                        @forelse ($teleconsultation['examen_cliniques'] as $motif)
                            <li>{{ $motif['fr_description'] }}</li>
                        @empty
                        @endforelse
                    </ol>
                    <span>Description examen clinique: {!! $teleconsultation['description_examen_clinique'] !!}</span>
                </fieldset>
            @endif

            <fieldset class="content-field mt-1">
                <legend>Examens à réaliser</legend>

                @if (count($teleconsultation['examen_complementaires'])>0)
                    <table>
                        <thead>
                            <tr>
                                <th>N°</th><th>Catégories</th><th>Examens</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($teleconsultation['type_examens'] as $type_examen)
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

            @if(count($teleconsultation['diagnostics']) > 0)
                <fieldset class="content-field mt-1">
                    <legend>Diagnostic ICD</legend>
                    <ol>
                        @forelse ($teleconsultation['diagnostics'] as $diagnostic)
                            <li><span style="padding:0 40px 0 0;">{{ $diagnostic['code_icd'] }}</span> {{ $diagnostic['name'] }}</li>
                        @empty
                        @endforelse
                    </ol>
                    <span>Description du Diagnostic: {!! $teleconsultation['description_diagnostic'] !!}</span>
                </fieldset>
            @endif

            @if(!is_null($teleconsultation['cat']))
                <fieldset class="content-field mt-1">
                    <legend>Conduite à tenir</legend>
                    {!! $teleconsultation['cat'] !!}
                </fieldset>
            @endif


            @if (count($teleconsultation['ordonnances'])>0)

                <fieldset class="content-field mt-1">
                    <legend>Ordonnances</legend>
                    <ol>
                        @forelse ($teleconsultation['ordonnances'] as $ordonnance)
                            <li>{!! $ordonnance['description'] !!}</li>
                        @empty
                        @endforelse
                    </ol>
                </fieldset>
            @endif

            <p><br/>Je vous remercie de m'avoir adressé votre patient(e) et vous adresse mes salutations confraternelles.</p>
            <p><i>Dossier relu et validé par l'équipe Medicasure</i></p>


            @include('pdf.includes.signature_medecin', ['medecin' => $medecin, 'format' => 'a4'])
        </div>
    </div>
@endsection

