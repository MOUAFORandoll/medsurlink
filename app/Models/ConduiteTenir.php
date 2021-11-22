<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConduiteTenir extends Model
{
    protected $fillable = [
        'conduite_a_tenir',
        'medecin_id',
        'medecin_control_id',
        'motif_consultation_id',
        'etat_validation_medecin',
        'date_validation_medecin',
    ];
}
