<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Netpok\Database\Support\RestrictSoftDeletes;

class Souscripteur extends Model
{
    use SoftDeletes;
    use RestrictSoftDeletes;

    /**
     * The relations restricting model deletion
     */
    protected $restrictDeletes = ['patients'];

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
        "sexe",
        "date_de_naissance",
        "age",
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

    public function patients(){
        return $this->hasMany(Patient::class,'souscripteur_id','user_id');
    }

    public function auteurs()
    {
        return $this->morphMany(Auteur::class, 'auteurable');
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }

}
