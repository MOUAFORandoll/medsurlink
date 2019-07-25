<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Allergie extends Model
{
    use SoftDeletes;
    protected $fillable = [
        "intitule",
        "description",
    ];

    public  function  consultations(){
        return $this->belongsToMany(ConsultationMedecineGenerale::class,'consultation_allergie','allergie_id','consultation_medecine_generale_id');
    }
}
