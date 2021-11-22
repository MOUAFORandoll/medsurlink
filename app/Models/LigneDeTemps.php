<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LigneDeTemps extends Model
{
    protected $fillable = [
        'dossier_medical_id',
        'motif_consultation',
        'etat',
        'date_consultation',
    ];
}
