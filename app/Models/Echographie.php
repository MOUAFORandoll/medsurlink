<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Echographie extends Model
{
    use SoftDeletes;

    protected $fillable = [
        "consultation_obstetrique_id",
        "date_creation",
        "type",
        "ddr",
        "dpa",
        "semaine_amenorrhee",
        "biometrie",
        "annexe",
        "description",
    ];
}
