<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Resultat extends Model
{
    use SoftDeletes;
    protected $fillable = [
        "dossier_medical_id",
        "consultation_medecine_generale_id",
        "type",
        "description",
        "date",
        "file",
        'archieved_at',
        'passed_at',
    ];

    public function dossier(){
        return $this->belongsTo(DossierMedical::class,'dossier_medical_id','id');
    }

    public function consultation(){
        return $this->belongsTo(ConsultationMedecineGenerale::class,'consultation_medecine_generale_id','id');
    }
}
