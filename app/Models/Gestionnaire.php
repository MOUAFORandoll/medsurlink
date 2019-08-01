<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Gestionnaire extends Model
{
    use SoftDeletes;


    protected $fillable = [
        "user_id",
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

    /**
     * Get all of the gestionnaire action.
     */
    public function auteurs()
    {
        return $this->morphMany(Auteur::class, 'auteurable');
    }

    /**
     * Get all of the gestionnaire action.
     */
    public function operations()
    {
        return $this->morphMany(Auteur::class, 'operationable');
    }
}
