@php
    use Carbon\Carbon;
@endphp
@extends('pdf.layouts.pdf', ['format' => 'a4'])
@section('title', "Bon de prise en charge de {$patient->user->name } du {$date} par {$medecin->civilite} {$medecin->user->name}")
@section('content')
    <div class="content mt-2">
        <h1 class="mt-2">Bon de prise en charge</h1>
    </div>
    <div id="content" class="default-margin">
        @include('pdf.includes.identification_patient', ['patient' => $patient])
        <div class="content">
            <div class="content-text mt-2">
                <p>
                    Concerne <strong>{{ $patient->sexe == "M" ? "M." : "Mme" }} {{ $patient->user->name }}</strong>, patient{{ $patient->sexe == "M" ? "" : "e" }} né{{ $patient->sexe == "M" ? "" : "e" }} le <strong>{{ Carbon::parse($patient->date_de_naissance)->locale(config('app.locale'))->translatedFormat('jS F Y') }}</strong>, résidant à <strong>{{ $patient->user->ville }} – {{ $patient->user->pays }}</strong> 
                </p>
                <p>
                    Honorée Consœur, Honoré Confrère, bonjour <br />
                    Voudriez-vous prendre contact avec {{ $patient->sexe == "M" ? "le" : "la" }} patient{{ $patient->sexe == "M" ? "" : "e" }} sus mentionnée
                        @if (count($bon_prise_en_charge['teleconsultations']) > 0)
                            en vue d'une consultation de <strong>{{ $bon_prise_en_charge['teleconsultations'][0]['type']['libelle'] }}</strong> le <strong>{{ Carbon::parse($bon_prise_en_charge['rendez_vous'][0]['date'])->locale(config('app.locale'))->translatedFormat('jS F Y') }}</strong>
                        @endif
                    Contact Patient{{ $patient->sexe == "M" ? "" : "e" }} : <strong>{{ $patient->user->telephone  }}</strong>
                </p>
            </div>


            @if(count($bon_prise_en_charge['motifs']) > 0)
                <fieldset class="content-field mt-1">
                    <legend>MOTIFS PRINCIPAUX DE CONSULTATION INITIALE</legend>
                    <ol>
                        @forelse ($bon_prise_en_charge['motifs'] as $motif)
                            <li>{{ $motif['description'] }}</li>
                        @empty
                        @endforelse
                    </ol>
                </fieldset>
            @endif

            @if($bon_prise_en_charge['ligne_temps'] !="")
                <fieldset class="content-field mt-1">
                    <legend>MOTIFS PRINCIPAUX DE CONSULTATION INITIALE</legend>
                    <ol>
                        @if (count($bon_prise_en_charge['ligne_temps']['motifs']) > 0)
                            @forelse ($bon_prise_en_charge['ligne_temps']['motifs'] as $motif)
                                <li>{{ $motif['description'] }}</li>
                            @empty
                            @endforelse
                        @else
                            <li>{{ $bon_prise_en_charge['ligne_temps']['motif']['description'] }}</li>
                        @endif
                    </ol>
                </fieldset>
            @endif

            <fieldset class="content-field mt-1">
                <legend>Plaintes</legend>
                {!! $bon_prise_en_charge['plainte'] !!}
            </fieldset>
            @if (count($bon_prise_en_charge['examens_analyses']) > 0)
                <fieldset class="content-field mt-1">
                    <legend>Bulletin d’examens / Ordonnances Disponibles</legend>
                    <table>
                        <tr>
                            <th>Catégories</th>
                            <th>Examens</th>
                            <th>Consulter</th>
                        </tr>
                        @forelse ($bon_prise_en_charge['examens_analyses'] as $item)
                            <tr>
                                @if($loop->iteration == 1)
                                    <td rowspan="{{ count($bon_prise_en_charge['examens_analyses']) }}">Bulletin d'examen</td>
                                @endif
                                <td>AB #{{ $item['id'] }}</td>
                                <td><a href="{{ $item['pdf'] }}" target="_blank">Cliquer ici</a></td>
                            </tr>
                        @empty
                        @endforelse
                        @forelse ($bon_prise_en_charge['ordonnances'] as $item)
                            <tr>
                                @if($loop->iteration == 1)
                                    <td rowspan="{{ count($bon_prise_en_charge['ordonnances']) }}">Ordonnance</td>
                                @endif
                                <td>Rx #{{ $item['id'] }}</td>
                                <td><a href="{{ $item['pdf'] }}" target="_blank">Cliquer ici</a></td>
                            </tr>
                        @empty
                        @endforelse
                        @forelse ($bon_prise_en_charge['examens_imageries'] as $item)
                            <tr>
                                @if($loop->iteration == 1)
                                    <td rowspan="{{ count($bon_prise_en_charge['examens_imageries']) }}">Examen Imageries</td>
                                @endif
                                <td>IM #{{ $item['id'] }}</td>
                                <td><a href="{{ $item['pdf'] }}" target="_blank">Cliquer ici</a></td>
                            </tr>
                        @empty
                        @endforelse
                    </table>
                </fieldset>
            @endif


            <div class="content-text mt-1">
                <p>N’hésitez pas à archiver votre rapport de prise en charge dans le dossier medical du patient sur Medsurlink <a href="https://www.medsurlink.com" target="_blank">medsurlink.com</a>.</p>
                <p>Si vous rencontrez des difficultés, n’hésitez pas à nous le transmettre par mail à  <a href="mailto:medical@medicasure.com" target="_blank">medical@medicasure.com</a> .</p>
                <p><br/>Je vous remercie d’avance de votre diligence.<br/>
                    Sincères salutations</p>
            </div>
            @include('pdf.includes.signature_medecin', ['medecin' => $medecin, 'format' => 'a4'])
        </div>
    </div>
@endsection

