<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Netpok\Database\Support\RestrictSoftDeletes;

class ConsultationMedecineGenerale extends Model
{
    use SoftDeletes;
    use RestrictSoftDeletes;

    /**
     * The relations restricting model deletion
     */
    protected $restrictDeletes = ['motifs','examensClinique','examensComplementaire','traitements','allergies','antecedents','conclusions'];

    protected $fillable = [
        "dossier_medical_id",
        "date_consultation",
        "anamese",
        "mode_de_vie",
        'archieved_at',
        'passed_at',
    ];

    public function dossier(){
        return $this->belongsTo(DossierMedical::class,'dossier_medical_id','id');
    }

    public  function  motifs(){
        return $this->belongsToMany(Motif::class,'consultation_motif','consultation_medecine_generale_id','motif_id');
    }

    public  function  examensClinique(){
        return $this->belongsToMany(ExamenClinique::class,'consultation_clinique','consultation_medecine_generale_id','examen_clinique_id');
    }
    public  function  examensComplementaire(){
        return $this->belongsToMany(ExamenComplementaire::class,'consultation_exam_com','consultation_medecine_generale_id','examen_complementaire_id');
    }

    public  function  traitements(){
        return $this->belongsToMany(Traitement::class,'consult_traitement','consultation_medecine_generale_id','traitement_id');
    }

    public  function  allergies(){
        return $this->belongsToMany(Allergie::class,'consultation_allergie','consultation_medecine_generale_id','allergie_id');
    }

    public function antecedents(){
        return $this->hasMany(Antecedent::class,'consultation_medecine_generale_id','id');
    }
    public function conclusions(){
        return $this->hasMany(Conclusion::class,'consultation_medecine_generale_id','id');
    }

}
