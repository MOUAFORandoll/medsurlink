<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Motif extends Model
{
    use SoftDeletes;

    protected $fillable = [
        "reference",
        "description",
        'slug'
    ];

    public  function  consultations(){
        return $this->belongsToMany(ConsultationMedecineGenerale::class,'consultation_motif','motif_id','consultation_medecine_generale_id');
    }

}
