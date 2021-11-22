<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConsultationExamenValidation extends Model
{
    protected $fillable = [
        'souscripteur_id',
        'examen_complementaire_id',
        'medecin_id',
        'medecin_control_id',
        'motif_consultation_id',
        'etat_validation_medecin',
        'etat_validation_souscripteur',
        'date_validation_medecin',
        'date_validation_souscripteur',
    ];
}