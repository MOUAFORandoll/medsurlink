@extends('.rapport.layouts.rapport')

@section('body')
    @component('.rapport.slots.customEnteteEtablissement',['etablissement'=>$compteRendu->etablissement,
                                                           'typeDeRapport'=>"Compte rendu opératpire"])
    @endcomponent


    <p>Honorée Consœur, Honoré Confrère,</p>

    <p>Je vous prie de trouver ci-joint le compte rendu opératoire concernant votre patient-e Madame/Monsieur Mr/Mme <strong>{{strtoupper($compteRendu->dossier->patient->user->nom)}} {{ucfirst($compteRendu->dossier->patient->user->prenom)}}</strong></p>

    <p>Je vous en souhaite bonne réception et tout en restant à votre entière disposition pour tout renseignement complémentaire, je vous adresse mes salutations confraternelles.</p>

    <p style="text-align: center">COMPTE RENDU OPERATOIRE</p>

    @component('.rapport.slots.champLibre',['titre'=>"Type d'intervention",
                                             'valeur'=>$compteRendu->type_intervention])
    @endcomponent

    @component('.rapport.slots.champLibre',['titre'=>"Histoire clinique ",
                                             'valeur'=>$compteRendu->histoire_clinique])
    @endcomponent

    @component('.rapport.slots.champLibre',['titre'=>"Date d’intervention ",
                                             'valeur'=>\Carbon\Carbon::parse($compteRendu->date_intervention)->format('d/m/Y H:i')])
    @endcomponent

    @component('.rapport.slots.champLibre',['titre'=>"Chirurgien (s)",
                                            'valeur'=>$compteRendu->chirugiens])
    @endcomponent

    @component('.rapport.slots.champLibre',['titre'=>"Aide(s)",
                                            'valeur'=>$compteRendu->aides])
    @endcomponent

    @component('.rapport.slots.champLibre',['titre'=>"Circulant(s)",
                                            'valeur'=>$compteRendu->circulants])
    @endcomponent

    @component('.rapport.slots.champLibre',['titre'=>"Anesthésistes ",
                                            'valeur'=>$compteRendu->anesthesistes])
    @endcomponent

    @component('.rapport.slots.champLibre',['titre'=>"Type d’anesthésie  ",
                                            'valeur'=>$compteRendu->type_anesthesie])
    @endcomponent

    @component('.rapport.slots.champLibre',['titre'=>"Description de l'intervention / Procédure ",
                                            'valeur'=>$compteRendu->description])
    @endcomponent

    @component('.rapport.slots.champLibre',['titre'=>"Traitement post opératoire ",
                                            'valeur'=>$compteRendu->traitement_post_operatoire])
    @endcomponent

    @if($compteRendu->dossier->patient->user->isMedicasure == '1')
    Dossier relu et validé par l'équipe Medicasure
    @endif

    <br>
    <p style="text-align: right">{{\Carbon\Carbon::parse($compteRendu->created_at)->format('d/m/Y')}} : {{\Carbon\Carbon::now()->format('d/m/Y')}}</p>
@endsection
