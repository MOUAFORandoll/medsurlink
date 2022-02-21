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
        'date_paiement',
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

    public function souscripteur(){
        return $this->belongsTo(Souscripteur::class,'user_id','user_id');
    }
    public function typeContrat(){
        return $this->belongsTo(Package::class,'type_contrat','id');
    }
}
