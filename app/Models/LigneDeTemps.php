<?php

namespace App\Models;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class LigneDeTemps extends Model
{
    use SoftDeletes;

    protected $table = 'ligne_de_temps';

    protected $fillable = [
        'dossier_medical_id',
        'motif_consultation_id',
        'etat',
        'date_consultation',
        'affiliation_id'
    ];

    // dossier médicaux lié à la ligne de temps
    public function dossier(){
        return $this->belongsTo(DossierMedical::class,'dossier_medical_id','id');
    }
    public function  motif(){
        return $this->belongsTo(Motif::class,'motif_consultation_id','id');
    }
    public function  kenesitherapie(){
        return $this->belongsTo(Kinesitherapie::class,'ligne_de_temps_id','id');
    }
    public function  consultationGeneral(){
        return $this->hasMany(ConsultationMedecineGenerale::class,'ligne_de_temps_id','id');
    }
    public function  cardiologie(){
        return $this->belongsTo(Cardiologie::class,'ligne_de_temps_id','id');
    }
    public function  consultationObstetrique(){
        return $this->belongsTo(ConsultationObstetrique::class,'ligne_de_temps_id','id');
    }
    public function  prescriptionValidation(){
        return $this->belongsTo(PrescriptionValidation::class,'ligne_de_temps_id','id');
    }
    public function  validations(){
        return $this->hasMany(ConsultationExamenValidation::class,'ligne_de_temps_id','id');
    }

    public function affiliation(){
        return $this->belongsTo(Affiliation::class);
    }

    public function activites_ama_patients(){
        return $this->hasMany(ActiviteAmaPatient::class, 'ligne_temps_id');
    }
}
