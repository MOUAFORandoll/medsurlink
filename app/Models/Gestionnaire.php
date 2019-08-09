<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Gestionnaire extends Model
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
        "civilite",
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

    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }
}
