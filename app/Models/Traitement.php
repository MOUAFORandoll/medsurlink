<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Traitement extends Model
{
    use SoftDeletes;
    protected $fillable = [
        "intitule",
        "description",
        'slug'
    ];

    public  function  consultations(){
        return $this->belongsToMany(ConsultationMedecineGenerale::class,'consult_traitement','traitement_id','consultation_medecine_generale_id');
    }
}
