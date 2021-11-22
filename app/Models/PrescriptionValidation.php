<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrescriptionValidation extends Model
{
    protected $table = 'prescription_validation';

    protected $fillable = [
        'souscripteur_id',
        'traitement_propose',
        'medecin_id',
        'medecin_control_id',
        'motif_consultation_id',
        'etat_validation_medecin',
        'etat_validation_medecin',
        'date_validation_medecin',
        'date_validation_souscripteur',
    ];
}
