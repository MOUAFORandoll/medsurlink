<?php

namespace App\Models;
use App\User;

use Illuminate\Database\Eloquent\Model;

class Pec extends Model
{
    protected $table='pec';
    
    protected $fillable = [
        "patient_id",
        "etablissement_id",
        "creator",
    ];

    public function createur(){
        return $this->belongsTo(User::class,'creator','id');
    }

    public function etablissements(){
        return $this->belongsTo(EtablissementExercice::class,'etablissement_id','id');
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }
}
