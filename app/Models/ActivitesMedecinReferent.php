<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;

class ActivitesMedecinReferent extends Model
{
    use Sluggable;
    use SoftDeletes;

    protected $table = 'activites_medecin_referent';
    protected $fillable = [
        "description_fr",
        "description_en",
        "type", 
        "slug",
    ];

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'DossierAndTimestamp'
            ]
        ];
    }

    public function getDossierAndTimestampAttribute() {
        return Str::random(10) . ' ' .Carbon::now()->timestamp;
    }
}
