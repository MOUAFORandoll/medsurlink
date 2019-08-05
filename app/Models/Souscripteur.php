<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Souscripteur extends Model
{
    use SoftDeletes;


    protected $fillable = [
        "user_id",
        "nom",
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
    ];

    public function auteurs()
    {
        return $this->morphMany(Auteur::class, 'auteurable');
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }

}
