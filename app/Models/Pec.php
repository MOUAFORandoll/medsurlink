<?php

namespace App\Models;
use App\User;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Pec
 *
 * @property-read User $createur
 * @property-read \App\Models\EtablissementExercice $etablissements
 * @property-read User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Pec newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Pec newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Pec query()
 * @mixin \Eloquent
 */
class Pec extends Model
{
    protected $table='pec';
    
    protected $fillable = [
        "patient_id",
        "etablissement_id",
        "creator",
        "date_cloture"
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
