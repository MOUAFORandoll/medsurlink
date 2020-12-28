<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EtablissementExercicePatient extends Model
{
    use SoftDeletes;
    protected $table = 'etablissement_exercice_patient';
    protected $fillable = [
        "etablissement_id",
        "patient_id",
    ];
}
