<?php

namespace App\Models;

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
}
