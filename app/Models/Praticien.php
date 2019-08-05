<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Praticien extends Model
{
    use SoftDeletes;


    protected $fillable = [
        "user_id",
        "specialite_id",
        "civilite",
        "nom",
        "prenom",
        "nationalite",
        "ville",
        "pays",
        "telephone",
        "email",
        "quartier",
        "code_postal",
        "numero_ordre",
    ];

    public function etablissements(){
        return $this->belongsToMany(EtablissementExercice::class,'etablissement_exercice_praticien','praticien_id','etablissement_id');
    }
    public function specialite(){
        return $this->belongsTo(Specialite::class,'specialite_id','id');
    }

    public function auteurs()
    {
        return $this->morphMany(Auteur::class, 'auteurable');
    }
    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }

}
