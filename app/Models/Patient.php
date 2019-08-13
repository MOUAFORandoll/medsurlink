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
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'user_id';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;
    protected $fillable = [
        "user_id",
        "souscripteur_id",
        "sexe",
        "date_de_naissance",
        "age",
        "nom_contact",
        "tel_contact",
        "lien_contact",
//        "nom",
//        "nationalite",
//        "prenom",
//        "ville",
//        "pays",
//        "telephone",
//        "email",
//        "quartier",
//        "code_postal",

    ];

    /**
     * The relations restricting model deletion
     */
    protected $restrictDeletes = ['dossier'];

    public function souscripteur(){
        return $this->belongsTo(Souscripteur::class,'souscripteur_id','user_id');
    }

    public function affiliations(){
        return $this->hasMany(Affiliation::class,'patient_id','user_id');
    }
    public function dossier(){
        return $this->hasOne(DossierMedical::class,'patient_id','user_id');
    }

    public function auteurs()
    {
        return $this->morphMany(Auteur::class, 'auteurable');
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }


}
