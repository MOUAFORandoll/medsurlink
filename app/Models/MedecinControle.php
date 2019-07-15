<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MedecinControle extends Model
{
    use SoftDeletes;

    protected $dates = "date_de_naissance";

    protected $fillable = [
        "user_id",
        "specialite_id",
        "numero_ordre",
        "nom",
        "prenom",
        "civilite",
        "nationalite",
        "ville",
        "pays",
        "telephone",
        "email",
        "quartier",
        "code_postal",
    ];
}
