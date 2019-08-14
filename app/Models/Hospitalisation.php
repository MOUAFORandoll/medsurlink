<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Hospitalisation extends Model
{
    use SoftDeletes;
    protected $fillable = [
        "dossier_medical_id",
        "date_entree",
        "date_sortie",
        "histoire_clinique",
        "mode_de_vie",
        "evolution",
        "conclusion",
        "avis",
        "traitement_sortie",
        "rendez_vous",
        'slug'
    ];

    public function dossier(){
        return $this->belongsTo(DossierMedical::class,'dossier_medical_id','id');
    }

    public function examensClinique(){
        return $this->belongsToMany(ExamenClinique::class,'hospitalisation_exam_clin','hospitalisation_id','examen_clinique_id');
    }

    public function examensComplementaire(){
        return $this->belongsToMany(ExamenComplementaire::class,'hospitalisation_exam_com','hospitalisation_id','examen_complementaire_id');
    }
}
