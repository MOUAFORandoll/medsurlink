<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DossierAllergie extends Model
{
    use SoftDeletes;

    protected $fillable = [
        "dossier_medical_id",
        "allergie_id",
    ];
}
