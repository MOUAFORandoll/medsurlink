<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EtablissementExercicePraticien extends Model
{
    use SoftDeletes;

    protected $fillable = [
      "etablissement_id",
      "praticien_id",
    ];
}
