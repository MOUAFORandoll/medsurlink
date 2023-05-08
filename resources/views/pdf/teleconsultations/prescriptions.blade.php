@php
    use Carbon\Carbon;
@endphp
@extends('pdf.layouts.pdf')
@section('title', "Prescription des médicaments de {$patient->user->name } du {$date} par {$medecin->civilite} {$medecin->user->name}")
@section('content')
    <div class="content mt-2">
        <h1 class="mt-2">Prescription des médicaments</h1>
    </div>
    <div id="content" class="default-margin">
        @include('pdf.includes.identification_patient', ['patient' => $patient])
        <div class="content">
            @if (count($prescription['medicaments'])>0)
                <fieldset class="content-field mt-1">
                    <legend>Liste des médicaments</legend>

                    @if (count($prescription['medicaments'])>0)
                        <table>
                            <thead>
                                <tr>
                                    <th>N°</th><th>Médicaments</th><th>Posologies</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($prescription['medicaments'] as $medicament)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $medicament['nom_commerciale'] }}</td>
                                        <td>  {{ $medicament['pivot']['quantite_lors_une_prise'] }} comprimé {{ $medicament['pivot']['nombre_de_prise'] }} fois tout les {{ $medicament['pivot']['nombre_de_fois'] }} heures pendant {{ $medicament['pivot']['duree_traitement'] }} jours
                                            (
                                                @forelse ($medicament['horaire_de_prises']  as $horaire_de_prise)
                                                    {{ $horaire_de_prise['libelle'] }}
                                                    @if(!$loop->last)
                                                        {{", "}}
                                                    @endif
                                                @empty
                                                @endforelse
                                            ) renouvelable {{ $medicament['pivot']['nombre_renouvelement'] }} fois. <br>
                                            Nombre d'unité d'achat : {{ $medicament['pivot']['nombre_unite_achat'] }}
                                        </td>
                                    </tr>
                                @empty
                                @endforelse
                            </tbody>
                        </table>
                    @endif
                </fieldset>
            @endif
            <div class="content-text mt-1">
                <br>
                <p><b><i>NB: Recontacter le prescripteur rapidement en cas d'aggravation des symptômes</i></b></p>
            </div>
            @include('pdf.includes.signature_medecin', ['medecin' => $medecin])
        </div>
    </div>
@endsection

