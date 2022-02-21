<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConduiteTenir extends Model
{
    protected $table = 'cat';

    protected $fillable = [
        'conduite_a_tenir',
        'medecin_id',
        'medecin_control_id',
        'ligne_de_temps_id',
        'etat_validation_medecin',
        'date_validation_medecin',
    ];

    public function ligneDeTemps(){
        return $this->belongsTo(LigneDeTemps::class,'ligne_de_temps_id','id');
    }
}
