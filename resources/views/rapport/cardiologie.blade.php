@extends('.rapport.layouts.rapport')

@section('body')
    @component('.rapport.slots.enteteEtablissement',['etablissement'=>$consultation->etablissement])
    @endcomponent

    @component('.rapport.slots.presentation',[
                                        'type_consultation'=>'cardiologie',
                                        'date_consultation'=>$consultation->date_consultation,
                                        'patient'=>$consultation->dossier->patient,
                                        'motifs'=>$consultation->motifs])
    @endcomponent

    @component('.rapport.slots.motifs',['motifs'=>$consultation->motifs])
    @endcomponent

    @component('.rapport.slots.anamnese',['anamnese'=>$consultation->anamnese])
    @endcomponent

    @component('.rapport.slots.modeDeVie',['consultation'=>$consultation])
    @endcomponent

    @component('.rapport.slots.antecedents',[
    'antecedents'=>$consultation->dossier->antecedents,
    'dossier'=>$consultation->dossier,
    'consultation'=>$consultation])
    @endcomponent

    @component('.rapport.slots.allergies',['allergies'=>$consultation->dossier->allergies])
    @endcomponent

    @component('.rapport.slots.traitementActuel',['traitements'=>$consultation->dossier->traitements])
    @endcomponent

    @component('.rapport.slots.parametre',['parametres'=>$consultation->parametresCommun])
    @endcomponent

    @component('.rapport.slots.examen',['examen'=>$consultation->examen_clinique,'titre'=>'Examen clinique'])
    @endcomponent

    @component('.rapport.slots.examenCardio',['examens'=>$consultation->examenCardios])
    @endcomponent

    @component('.rapport.slots.examen',['examen'=>$consultation->conclusion,'titre'=>'Diagnostic'])
    @endcomponent

    @component('.rapport.slots.conduiteATenir',['conduite'=>$consultation->conduite_a_tenir])
    @endcomponent

    @if(!is_null($consultation->rendez_vous) && $consultation->rendez_vous != 'null' )
        <h4 class="sous-titre-rapport">Date de rendez vous</h4>
        @if($consultation->rendez_vous != 'null')
            <p>{{\Carbon\Carbon::parse($consultation->rendez_vous)->format('d/m/Y')}}</p>
        @endif
    @endif

    @component('.rapport.slots.files',['files'=>$consultation->files])
    @endcomponent

    @component('.rapport.slots.remerciement')
    @endcomponent

    @component('.rapport.slots.revisiteurs',['medecins'=>$revisiteurs])
    @endcomponent

    @component('.rapport.slots.generateur',['generateur'=>$generateur])
    @endcomponent

    @component('.rapport.slots.contributeurs',['operationables'=>$consultation->operationables])
    @endcomponent
@endsection
