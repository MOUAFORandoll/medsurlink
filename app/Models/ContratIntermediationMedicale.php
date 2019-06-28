<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContratIntermediationMedicale extends Model
{
    use SoftDeletes;

    protected $fillable = [
        "nomSouscripteur",
        "paysResidenceSouscripteur",
        "villeResidenceSouscripteur",
        "telephoneSouscripeur1",
        "telephoneSouscripeur2",
        "emailSouscripteur1",
        "emailSouscripteur2",
        "typeSouscription",
        "paysSouscription",
        "sexeSouscripteur",
        "nomPatient",
        "prenomPatient",
        "sexePatient",
        "nomAffilie",
        "sexeAffilie",
        "ageAffilie",
        "paysResidenceAffilie",
        "villeResidenceAffilie",
        "telephoneAffilie1",
        "dateNaissanceAffilie",
        "telephoneAffilie2",
        "personneContact1",
        "personneContact2",
        "nomContact",
        "montantSouscription",
        "lieuEtablissement",
        "dateSignature",
    ];
}
