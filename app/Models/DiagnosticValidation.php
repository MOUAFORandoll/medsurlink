<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\DiagnosticValidation
 *
 * @property-read \App\Models\LigneDeTemps $ligneDeTemps
 * @property-read \App\Models\Praticien $medecin
 * @property-read \App\Models\MedecinControle $medecinControl
 * @method static \Illuminate\Database\Eloquent\Builder|DiagnosticValidation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DiagnosticValidation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DiagnosticValidation query()
 * @mixin \Eloquent
 */
class DiagnosticValidation extends Model
{
    protected $table = 'diagnostic_validation';

    protected $fillable = [
        'medecin_id',
        'medecin_control_id',
        'diagnostic_code',
        'diagnostic_libelle',
        'ligne_de_temps_id',
        'etat_validation_medecin',
        'date_validation_medecin',
        'ligne_de_temps_id',
    ];
    public function ligneDeTemps(){
        return $this->belongsTo(LigneDeTemps::class,'ligne_de_temps_id','id');
    }
    public function medecinControl(){
        return $this->belongsTo(MedecinControle::class,'medecin_control_id','id');
    }
    public function medecin(){
        return $this->belongsTo(Praticien::class,'medecin_id','id');
    }
}
