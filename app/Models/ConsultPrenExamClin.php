<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ConsultPrenExamClin extends Model
{
    use SoftDeletes;

    protected $fillable = [
        "consultation_prenatale_id",
        "examen_clinique_id",
    ];
}
