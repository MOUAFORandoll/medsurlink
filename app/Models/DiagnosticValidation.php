<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DiagnosticValidation extends Model
{
    protected $table = 'diagnostic_validation';

    protected $fillable = [
        'medecin_id',
        'medecin_control_id',
        'diagnostic_code',
        'diagnostic_libelle',
        'ligne_de_temps_id',
        'etat_validation_medecin',
        'date_validation_medecin',
    ];
    public function ligneDeTemps(){
        return $this->belongsTo(LigneDeTemps::class,'ligne_de_temps_id','id');
    }
    public function medecinControl(){
        return $this->belongsTo(MedecinControle::class,'medecin_control_id','id');
    }
    public function medecin(){
        return $this->belongsTo(Praticien::class,'medecin_id','id');
    }
}
