<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Praticien extends Model
{
    use SoftDeletes;
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
        "specialite_id",
        "civilite",
        "numero_ordre",
//        "nom",
//        "prenom",
//        "nationalite",
//        "ville",
//        "pays",
//        "telephone",
//        "email",
//        "quartier",
//        "code_postal",
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
