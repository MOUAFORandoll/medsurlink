@extends('.rapport.layouts.rapport')

@section('body')
    @component('.rapport.slots.customEnteteEtablissement',['etablissement'=>$hospitalisation->etablissement,
                                                            'typeDeRapport'=>"Rapport d'hospitalisation"])
    @endcomponent

    @component('.rapport.hospitalisation.slots.presentation',[
                                        'patient'=>$hospitalisation->dossier->patient,
                                        'date_entree'=>$hospitalisation->date_entree,
                                        'date_sortie'=>$hospitalisation->date_sortie,
                                        'nomEtablissement'=>$hospitalisation->etablissement->name])
    @endcomponent

    @component('.rapport.slots.champLibre',['titre'=>'Histoire clinique',
                                             'valeur'=>$hospitalisation->histoire_clinique])
    @endcomponent

    @component('.rapport.slots.champLibre',['titre'=>'Mode de vie',
                                             'valeur'=>$hospitalisation->mode_de_vie])
    @endcomponent

    @component('.rapport.slots.champLibre',['titre'=>'Évolution',
                                             'valeur'=>$hospitalisation->evolution])
    @endcomponent

    @component('.rapport.slots.champLibre',['titre'=>'Examen(s) Clinique(s)',
                                             'valeur'=>$hospitalisation->examen_clinique])
    @endcomponent

    @component('.rapport.slots.champLibre',['titre'=>'Examen(s) Complémentaire(s)',
                                             'valeur'=>$hospitalisation->examen_complementaire])
    @endcomponent

    @component('.rapport.slots.champLibre',['titre'=>'Diagnostic',
                                             'valeur'=>$hospitalisation->conclusion])
    @endcomponent

    @component('.rapport.slots.champLibre',['titre'=>'Avis',
                                             'valeur'=>$hospitalisation->avis])
    @endcomponent

    @component('.rapport.slots.champLibre',['titre'=>'Traitement de sortie',
                                             'valeur'=>$hospitalisation->traitement_sortie])
    @endcomponent

    @component('.rapport.slots.dateRdv',['date'=>$hospitalisation->rendez_vous])
    @endcomponent

    @component('.rapport.slots.revisiteurs',['medecins'=>$revisiteurs])
    @endcomponent

    @component('.rapport.slots.generateur',['generateur'=>$generateur])
    @endcomponent

@endsection
