<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExamenClinique extends Model
{
    use SoftDeletes;

    protected $fillable = [
        "reference",
        "description",
    ];

    public  function  consultations(){
        return $this->belongsToMany(ConsultationMedecineGenerale::class,'consultation_clinique','examen_clinique_id','consultation_medecine_generale_id');
    }
}
