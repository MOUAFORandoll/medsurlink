<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Patient extends Model
{
    use SoftDeletes;


    protected $fillable = [
        "user_id",
        "nom",
        "souscripteur_id",
        "prenom",
        "sexe",
        "date_de_naissance",
        "age",
        "nationalite",
        "ville",
        "pays",
        "telephone",
        "email",
        "quartier",
        "code_postal",
        "nom_contact",
        "tel_contact",
        "lien_contact",
    ];

    public function souscripteur(){
        return $this->belongsTo(Souscripteur::class,'souscripteur_id','id');
    }
}
