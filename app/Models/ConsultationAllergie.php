<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ConsultationAllergie extends Model
{
    use SoftDeletes;

    protected $fillable = [
        "consultation_medecine_generale_id",
        "allergie_id",
        "date",
    ];
}
