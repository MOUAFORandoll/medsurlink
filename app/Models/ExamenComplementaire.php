<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExamenComplementaire extends Model
{
    use Sluggable;
    use SoftDeletes;
    protected $table = 'examen_complementaires';
    protected $fillable = [
        "fr_description",
        "en_description",
        "reference",
        "slug",
        "prix",
    ];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'DossierAndTimestamp'
            ]
        ];
    }
    public function examenComplementairePrix(){
        return $this->hasMany(ExamenEtablissementPrix::class,'examen_complementaire_id','id');
    }
    public function getDossierAndTimestampAttribute() {
        return Str::random(10) . ' ' .Carbon::now()->timestamp;
    }
}
