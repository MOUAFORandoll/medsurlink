<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EtablissementExercicePraticien extends Model
{
    use SoftDeletes;
    protected $table = "etablissement_exercice_praticien";

    protected $fillable = [
      "etablissement_id",
      "praticien_id",
    ];
}
