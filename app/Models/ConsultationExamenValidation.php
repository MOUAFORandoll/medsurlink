<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConsultationExamenValidation extends Model
{
    protected $table = 'consultation_examen_validation';

    protected $fillable = [
        'souscripteur_id',
        'examen_complementaire_id',
        'medecin_id',
        'medecin_control_id',
<<<<<<< HEAD
        'ligne_de_temps_id',
=======
>>>>>>> d6be2799fd64fb28c1cef67a41fe9690960bf331
        'etat_validation_medecin',
        'etat_validation_souscripteur',
        'date_validation_medecin',
        'date_validation_souscripteur',
        'ligne_de_temps_id'
    ];

    public function ligneDeTemps(){
        return $this->belongsTo(LigneDeTemps::class,'ligne_de_temps_id','id');
    }
    public function examenComplementaire(){
        return $this->belongsTo(ExamenComplementaire::class,'examen_complementaire_id','id');
    }
    public function otherExamenComplementaire(){
        return $this->belongsTo(OtherComplementaire::class,'examen_complementaire_id','id');
    }
}
