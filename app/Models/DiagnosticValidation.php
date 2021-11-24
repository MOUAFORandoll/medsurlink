<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DiagnosticValidation extends Model
{
    protected $table = 'diagnostic_validation';

    protected $fillable = [
        'medecin_id',
        'medecin_control_id',
        'medecin_control_id',
        'etat_validation_medecin',
        'date_validation_medecin',
        'ligne_de_temps_id',
    ];
}
