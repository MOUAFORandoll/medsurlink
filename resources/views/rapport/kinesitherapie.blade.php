@extends('.rapport.layouts.rapport')

@section('body')
    @component('.rapport.slots.customEnteteEtablissement',['etablissement'=>$kinesitherapie->etablissement,
                                                            'typeDeRapport'=>"Kinésithérapie"])
    @endcomponent

    <p>Honorée Dre, Honoré Dr,</p>

    <p>J'ai vu en date du {{dateFormat($kinesitherapie->date_consultation)}}, pour une consultation de kinésithérapie, votre patient(e)
        {{strtoupper(patientLastName($kinesitherapie)). ' '. patientFirstName($kinesitherapie)}} né(e) le {{dateFormat($kinesitherapie->dossier->patient->date_de_naissance)}} pour :
    </p>

    @component('.rapport.slots.rubrique',['titre'=>"Motifs",
                                            'valeur'=>$kinesitherapie->motifs])
    @endcomponent

    @component('.rapport.slots.rubrique',['titre'=>"Anamnèse",
                                            'valeur'=>$kinesitherapie->anamnese])
    @endcomponent

    @component('.rapport.slots.rubrique',['titre'=>"Profession",
                                            'valeur'=>$kinesitherapie->profession])
    @endcomponent

    @component('.rapport.slots.rubrique',['titre'=>"Evaluation globale",
                                            'valeur'=>$kinesitherapie->evaluation_globale])
    @endcomponent

    @component('.rapport.slots.rubrique',['titre'=>"Impression diagnostique",
                                            'valeur'=>$kinesitherapie->impression_diagnostique])
    @endcomponent

    @component('.rapport.slots.rubrique',['titre'=>"Examen(s) complémentaire(s)",
                                            'valeur'=>$kinesitherapie->examens_complementaires])
    @endcomponent

    @component('.rapport.slots.rubrique',['titre'=>"Conduite à tenir",
                                            'valeur'=>$kinesitherapie->conduite_a_tenir])
    @endcomponent

    @if(count($kinesitherapie->files)>0)
        @foreach($kinesitherapie->files as $file)
            <a href="{{config('app.url')}}/public/storage/{{$file->chemin}}">{{$file->nom}}</a><br>
        @endforeach
    @endif

    @if($kinesitherapie->rdv)
        @component('.rapport.slots.rubrique',['titre'=>"Date du rendez-vous",
                                                'valeur'=>dateFormat($kinesitherapie->rdv->date)])
        @endcomponent

        @component('.rapport.slots.rubrique',['titre'=>"Motif du rendez-vous",
                                                'valeur'=>dateFormat($kinesitherapie->rdv->motifs)])
        @endcomponent

        @component('.rapport.slots.rubrique',['titre'=>"Nom du médecin",
                                                'valeur'=>$kinesitherapie->rdv->praticien ?
                                                $kinesitherapie->rdv->praticien->nom :
                                                $kinesitherapie->rdv->nom_medecin
                                                ])
        @endcomponent
    @endif
@endsection
