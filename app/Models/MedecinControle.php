<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MedecinControle extends Model
{
    use SoftDeletes;

    protected $fillable = [
        "user_id",
        "specialite_id",
        "numero_ordre",
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
