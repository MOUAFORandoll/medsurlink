<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,400i,500,500i,600,700,800,900&display=swap" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Raleway:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900&display=swap' rel='stylesheet'>

    <title>Medsurlink</title>
    @section('style')
</head>
<body>

@component('../slots/enteteEtablissement',['etablissement'=>$consultation->etablissement])
@endcomponent

@component('../slots/presentation',[
                                    'type_consultation'=>'médecine générale',
                                    'date_consultation'=>$consultation->date_consultation,
                                    'patient'=>$consultation->dossier->patient,
                                    'motifs'=>$consultation->motifs])
@endcomponent

@component('../motifs',['motifs'=>$consultation->motifs])
@endcomponent

@component('../anamnese',['anamnese'=>$consultation->anamese])
@endcomponent

@component('../modeDeVie',['consultation'=>$consultation])
@endcomponent


@if(count($consultation->dossier->antecedents) >0)
    @component('../antecedents',['antecedents'=>$consultation->dossier->antecedents])
    @endcomponent
@endif

@if(count($consultation->dossier->allergies)>0)
    @component('../allergies',['allergies'=>$consultation->dossier->allergies])
    @endcomponent
@endif

@if(count($consultation->dossier->traitements) >0)
    @component('../traitementActuel',['traitements'=>$consultation->dossier->traitements])
    @endcomponent
@endif


@component('../parametre',['parametres'=>$consultation->parametresCommun])
@endcomponent

@component('../examen',['examen'=>$consultation->examen_clinique,'titre'=>'Examen clinique'])
@endcomponent

@component('../examen',['examen'=>$consultation->examen_complementaire,'titre'=>'Examen(s) complémentaire(s)'])
@endcomponent

@component('../diagnosticList',['conclusions'=>$consultation->conclusions])
@endcomponent

@component('conduiteATenir',['conduite'=>$consultation->traitement_propose])
@endcomponent

@component('../files',['files'=>$consultation->files])
@endcomponent




@component('../remerciement')
@endcomponent

@component('../revisiteurs',['medecins'=>$medecins])
@endcomponent

@component('../generateur',['generateur'=>$generateur])
@endcomponent


@component('../contributeurs',['contributeurs'=>$consultation->operationables])
@endcomponent

</body>
</html>
