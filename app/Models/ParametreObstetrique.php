<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ParametreObstetrique extends Model
{
    use SoftDeletes;
    protected $table = "parametre_obs";
    protected $fillable = [
        "consultation_prenatale_id",
        "poids",
        "ta_systolique",
        "ta_diastolique",
        "hauteur_urine",
        "toucher_vaginal",
        "bruit_du_coeur",
    ];

    public function consultationPrenatale(){
        return $this->belongsTo(ConsultationPrenatale::class,'consultation_prenatale_id','id');
    }
}
