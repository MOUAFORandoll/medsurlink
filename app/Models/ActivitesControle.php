<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;

class ActivitesControle extends Model
{
    use Sluggable;
    use SoftDeletes;

    protected $table = 'activites_controle';
    protected $fillable = [
        'activite_id',
        'creator',
        'commentaire',
        'statut',
        'date_cloture',
        'slug',
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
