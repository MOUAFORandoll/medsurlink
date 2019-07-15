<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Praticien extends Model
{
    use SoftDeletes;

    protected $dates = "date_de_naissance";

    protected $fillable = [
        "user_id",
        "profession_id",
        "specialite_id",
        "etablissement_id",
        "civilite",
        "nom",
        "prenom",
        "date_de_naissance",
        "nationalite",
        "ville",
        "pays",
        "telephone",
        "email",
        "quartier",
        "code_postal",
    ];
}
