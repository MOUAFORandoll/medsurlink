<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LigneDeTemps extends Model
{
    protected $table = 'ligne_de_temps';

    protected $fillable = [
        'dossier_medical_id',
        'motif_consultation',
        'etat',
        'date_consultation',
    ];
}
