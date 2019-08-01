<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExamenComplementaire extends Model
{
    use SoftDeletes;

    protected $fillable = [
        "reference",
        "description",
    ];

    public  function  consultations(){
        return $this->belongsToMany(ConsultationMedecineGenerale::class,'consultation_exam_com','examen_complementaire_id','consultation_medecine_generale_id');
    }

    public function hospitalisation(){
        return $this->belongsToMany(Hospitalisation::class,'hospitalisation_exam_com','examen_clinique_id','hospitalisation_id');
    }
}
