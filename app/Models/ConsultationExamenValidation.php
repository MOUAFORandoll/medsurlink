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
        'etat_validation_medecin',
        'etat_validation_souscripteur',
        'date_validation_medecin',
        'date_validation_souscripteur',
        'ligne_de_temps_id'
    ];
}