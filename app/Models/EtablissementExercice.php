<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EtablissementExercice extends Model
{
    use SoftDeletes;

    protected $fillable = [
        "name",
        "description"
    ];

    public function praticiens(){
        return $this->belongsToMany(Praticien::class,'etablissement_exercice_praticien','etablissement_id','praticien_id');
    }
}
