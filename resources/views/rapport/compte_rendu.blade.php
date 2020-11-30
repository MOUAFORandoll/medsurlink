@extends('.rapport.layouts.rapport')

@section('body')

<!--     @component('.rapport.slots.customEnteteEtablissement',['etablissement'=>$compteRendu->etablissement,
                                                           'typeDeRapport'=>"Compte rendu opératpire"])
    @endcomponent -->
<div class="container-doc">    
      <div class="row wrapper-page">
        <div class="col-left">
            @if(!is_null($compteRendu->etablissement->logo)  && $compteRendu->etablissement->logo !=='')
                <div class="rapport-logo-wrapper">
                    <img src="{{public_path('/storage/'.$etablissement->logo)}}" class="logo-rapport" alt="" />
                </div>
            @endif
            <p style="" class="textVert"><b>{{$compteRendu->etablissement->name}}</b></p>
            <p class="textBlack"><strong>{{$compteRendu->etablissement->adresse}}</br>
          </p>
            <br>
        </div>
        <div class="col-right">
            <p style="" class="textVert" style=""><b style="font-size:18px">COMPTE RENDU OPERATOIRE</b></p>
            <img style="padding-right:0px" src="{{public_path('images/separator.png')}}" class="logo-rapport" alt="" /> 
        </div>
      </div>
     <div class="welcome" style="marging-top:10px;">
        <p>Honorée Consœur, Honoré Confrère,</br>

        Je vous prie de trouver ci-joint le compte rendu opératoire concernant votre patient-e Madame/Monsieur Mr/Mme <strong>{{strtoupper($compteRendu->dossier->patient->user->nom)}} {{ucfirst($compteRendu->dossier->patient->user->prenom)}}</strong>

        Je vous en souhaite bonne réception et tout en restant à votre entière disposition pour tout renseignement complémentaire,<strong> je vous adresse mes salutations confraternelles.</strong></br>
        </p>
    </div>


    @component('.rapport.slots.rubrique',['titre'=>"Type d'intervention",
                                             'valeur'=>$compteRendu->type_intervention])
    @endcomponent

    @component('.rapport.slots.rubrique',['titre'=>"Histoire clinique ",
                                             'valeur'=>$compteRendu->histoire_clinique])
    @endcomponent

    @component('.rapport.slots.rubrique',['titre'=>"Date d’intervention ",
                                             'valeur'=>\Carbon\Carbon::parse($compteRendu->date_intervention)->format('d/m/Y H:i')])
    @endcomponent

    @component('.rapport.slots.rubrique',['titre'=>"Chirurgien (s)",
                                            'valeur'=>$compteRendu->chirugiens])
    @endcomponent

    @component('.rapport.slots.rubrique',['titre'=>"Aide(s)",
                                            'valeur'=>$compteRendu->aides])
    @endcomponent

    @component('.rapport.slots.rubrique',['titre'=>"Circulant(s)",
                                            'valeur'=>$compteRendu->circulants])
    @endcomponent

    @component('.rapport.slots.rubrique',['titre'=>"Anesthésistes ",
                                            'valeur'=>$compteRendu->anesthesistes])
    @endcomponent

    @component('.rapport.slots.rubrique',['titre'=>"Type d’anesthésie  ",
                                            'valeur'=>$compteRendu->type_anesthesie])
    @endcomponent

    @component('.rapport.slots.rubrique',['titre'=>"Description de l'intervention / Procédure ",
                                            'valeur'=>$compteRendu->description])
    @endcomponent

    @component('.rapport.slots.rubrique',['titre'=>"Traitement post opératoire ",
                                            'valeur'=>$compteRendu->traitement_post_operatoire])
    @endcomponent
    <div class="" style="text-align:center">
        <img src="{{public_path('images/separator.png')}}" class="logo-rapport" alt="" /> 
    </div> 
     <div class="row-flex">
         <div>
            <p style="text-align:left;font-size:10px;font-style: italic;">
            @if($compteRendu->dossier->patient->user->isMedicasure == '1')
            Dossier relu et validé par l'équipe <strong class="textViolet">Medicasure</strong>
            @endif
            </p>
         </div>
         <div classe="date">
             <p style="text-align: right;font-style: italic;">
               <b class="textViolet" style="font-size:9px; ">Date de création</b>
               <b class="textDate" style="font-size:12px">: {{\Carbon\Carbon::parse($compteRendu->created_at)->format('d/m/Y')}}</b>
             </p>
             <p style="text-align: right; marging-top:-10px; font-style: italic;">
                 <b class="textViolet" style="font-size:9px">Date d'impression</b>
                 <b class="textDate" style="font-size:12px">: {{\Carbon\Carbon::now()->format('d/m/Y')}}</b>
            </p>
         </div>
    </div>
    
</div>
@endsection
