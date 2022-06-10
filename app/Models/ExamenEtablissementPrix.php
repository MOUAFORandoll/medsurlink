<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamenEtablissementPrix extends Model
{
    protected $table = 'examen_etablissement_prix';

    protected $fillable = [
        'etablissement_exercices_id',
        'examen_complementaire_id',
        'other_complementaire_id',
        'prix',
        'ligne_de_temps_id'
    ];
    public function etablissement(){
        return $this->belongsTo(EtablissementExercice::class,'etablissement_exercices_id','id');
    }
    public function examenComplementaire(){
        return $this->belongsTo(ExamenComplementaire::class,'examen_complementaire_id','id');
    }
    public function otherExamenComplementaire(){
        return $this->belongsTo(OtherComplementaire::class,'other_complementaire_id','id');
    }
}
