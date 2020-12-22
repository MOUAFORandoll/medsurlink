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
                                                'valeur'=>$kinesitherapie->rdv->motifs])
        @endcomponent

        @component('.rapport.slots.rubrique',['titre'=>"Nom du médecin",
                                                'valeur'=>$kinesitherapie->rdv->praticien ?
                                                $kinesitherapie->rdv->praticien->nom :
                                                $kinesitherapie->rdv->nom_medecin
                                                ])
        @endcomponent
    @endif
    @if($kinesitherapie->dossier->patient->user->isMedicasure == '1')
        <p><i>Dossier relu et validé par l'équipe Medicasure</i></p>
    @endif
    @if(count($medecins) != 0)
        <h4>Medecin(s) ayant revisité votre consultation</h4>
        @foreach($medecins as $medecin)
            @if(!is_null($medecin->user))
                <div style="display: inline">
                    @if(!is_null($medecin->signature))
                        <div>
                            <img width="300px" height="auto" src={{public_path('/storage/'.$medecin->signature)}} />
                        </div>
                    @endif

                    <p>{{$medecin->civilite}} {{is_null($medecin->user->prenom) ? "" :  $medecin->user->prenom }} {{$medecin->user->nom}}</p>

                    @if(!is_null($medecin->numero_ordre))
                        @if($medecin->numero_ordre != 'null' && strlen($medecin->numero_ordre ) >0)
                            <p>Numéro d'ordre: {{$medecin->numero_ordre}}</p>
                        @endif
                    @endif
                </div>
            @endif
        @endforeach
    @endif
    <div style="display: inline">
        @if(!is_null($praticiens->user))
            <p>Généré par <b>{{$praticiens->civilite}} {{is_null($praticiens->user->prenom) ? "" :  $praticiens->user->prenom }} {{$praticiens->user->nom}}</b></p>
            @if(!is_null($praticiens->numero_ordre))
                @if($praticiens->numero_ordre != 'null' && strlen($praticiens->numero_ordre ) >0)
                    <p>Numéro d'ordre: {{$praticiens->numero_ordre}}</p>
                @endif
            @endif
        @endif
        <p style="text-align: right"> Date de création : <b>{{\Carbon\Carbon::parse()->format('d/m/Y')}}</b></p>

        @isset($signature)
            @if(!is_null($signature) && strlen($signature)>0)
                <div>
                    <img  style="float: right" width="300px" height="auto" src={{public_path('/storage/'.$signature)}} />
                </div>
            @endif
        @endisset
    </div>
    @if(count($kinesitherapie->operationables) >0)
        <p>Contributeurs</p>
        @foreach($mContributeurs as $medecin)
            @if(!is_null($medecin->user))
                <div style="display: inline">
                    @if(!is_null($medecin->signature))
                        <div>
                            <img width="300px" height="auto" src={{public_path('/storage/'.$medecin->signature)}} />
                        </div>
                    @endif

                    <p>{{$medecin->civilite}} {{is_null($medecin->user->prenom) ? "" :  $medecin->user->prenom }} {{$medecin->user->nom}}</p>

                    @if(!is_null($medecin->numero_ordre))
                        @if($medecin->numero_ordre != 'null' && strlen($medecin->numero_ordre ) >0)
                            <p>Numéro d'ordre: {{$medecin->numero_ordre}}</p>
                        @endif
                    @endif
                </div>
            @endif
        @endforeach
        @foreach($pContributeurs as $praticien)
            @if(!is_null($praticien->user))
                <div style="display: inline">
                    @if(!is_null($praticien->signature))
                        <div>
                            <img width="300px" height="auto" src={{public_path('/storage/'.$praticien->signature)}} />
                        </div>
                    @endif

                    <p>{{$praticien->civilite}} {{is_null($praticien->user->prenom) ? "" :  $praticien->user->prenom }} {{$praticien->user->nom}}</p>

                    @if(!is_null($praticien->numero_ordre))
                        @if($praticien->numero_ordre != 'null' && strlen($praticien->numero_ordre ) >0)
                            <p>Numéro d'ordre: {{$praticien->numero_ordre}}</p>
                        @endif
                    @endif
                </div>
            @endif
        @endforeach
    @endif
@endsection
