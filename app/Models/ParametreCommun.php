<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ParametreCommun extends Model
{
    use SoftDeletes;

    protected $fillable = [
        "consultation_medecine_generale_id",
        "poids",
        "taille",
        "bmi",
        "ta_systolique",
        "ta_diastolique",
        "temperature",
        "frequence_cardiaque",
        "sato2",
    ];

    public function consultation(){
        return $this->belongsTo(ConsultationMedecineGenerale::class,'consultation_medecine_generale_id','id');
    }
}
