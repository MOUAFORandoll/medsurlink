<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Netpok\Database\Support\RestrictSoftDeletes;

class Patient extends Model
{
    use SoftDeletes;
    use RestrictSoftDeletes;

    /**
     * The relations restricting model deletion
     */
    protected $restrictDeletes = ['dossier'];

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

    public function affiliations(){
        return $this->hasMany(Affiliation::class,'patient_id','id');
    }
    public function dossier(){
        return $this->hasOne(DossierMedical::class,'patient_id','id');
    }

    public function auteurs()
    {
        return $this->morphMany(Auteur::class, 'auteurable');
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }


}
