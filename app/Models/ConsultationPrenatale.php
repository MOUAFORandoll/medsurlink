<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ConsultationPrenatale extends Model
{
    use SoftDeletes;

    protected $fillable = [
        "consultation_obstetrique_id",
        "type_de_consultation",
        "plaintes",
        "antecedent_conjoint",
        "recommandations",
    ];

    public function parametreObstetrique(){
        return $this->hasMany(ParametreObstetrique::class,'consultation_prenatale_id','id');
    }

    public function consultationObstetrique(){
        return $this->belongsTo(ConsultationObstetrique::class,'consultation_obstetrique_id','id');
    }

    public function examensClinique(){
        return $this->belongsToMany(ExamenClinique::class,'consult_pren_exam_clin','consultation_prenatale_id','examen_clinique_id');
    }
    public function examensComplementaire(){
        return $this->belongsToMany(ExamenComplementaire::class,'consult_pren_exam_com','consultation_prenatale_id','examen_complementaire_id');
    }
}
