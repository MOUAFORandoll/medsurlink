<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ConduiteTenir
 *
 * @property-read \App\Models\LigneDeTemps $ligneDeTemps
 * @method static \Illuminate\Database\Eloquent\Builder|ConduiteTenir newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ConduiteTenir newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ConduiteTenir query()
 * @mixin \Eloquent
 */
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
