<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HospitalisationExamClin extends Model
{
    use SoftDeletes;
    protected $fillable = [
        "hospitalisation_id",
        "examen_clinique_id",
    ];
}
