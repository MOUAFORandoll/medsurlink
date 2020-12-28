<?php

namespace App\Models;

use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class AffiliationSouscripteur extends Model
{
    use SoftDeletes;
    use Sluggable;

    protected $fillable = [
        'user_id',
        'cim_id',
        'type_contrat',
        'nombre_paye',
        'nombre_restant',
        'montant',
        'slug',
    ];

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'generateSlug'
            ]

        ];
    }

    public function getGenerateSlugAttribute() {
        return Str::random(20).' '.Carbon::now()->timestamp;
    }
}
