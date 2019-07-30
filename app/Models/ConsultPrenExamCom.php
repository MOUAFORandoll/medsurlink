<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ConsultPrenExamCom extends Model
{
    use SoftDeletes;

    protected $fillable = [
        "consultation_prenatale_id",
        "examen_complementaire_id",
    ];
}
