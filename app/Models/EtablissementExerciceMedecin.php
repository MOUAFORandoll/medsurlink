<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EtablissementExerciceMedecin extends Model
{
    use SoftDeletes;
    protected $table = "etablissement_exercice_medecin";

    protected $fillable = [
        "etablissement_id",
        "medecin_controle_id",
        ];
}
