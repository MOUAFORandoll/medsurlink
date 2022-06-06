<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Antonrom\ModelChangesHistory\Traits\HasChangesHistory;
class VersionValidation extends Model
{
    use HasChangesHistory;

    protected $table = 'version_validations';

    protected $fillable = [
        'montant_prestation',
        'montant_medecin',
        'montant_souscripteur',
        'montant_total',
        'plus_value',
        'consultation_general_id',
        'ligne_de_temps_id',
        'version'
    ];

    public function consultation(){
        return $this->belongsTo(ConsultationMedecineGenerale::class,'consultation_general_id','id');
    }

    public function ligneDeTemps(){
        return $this->belongsTo(LigneDeTemps::class,'ligne_de_temps_id','id');
    }
}
