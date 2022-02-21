<?php

namespace App\Models;

use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class NotificationPaiement extends Model
{
    use SoftDeletes;
    use Sluggable;

    protected $fillable = [
      "type",
      "code_contrat",
      "pay_token",
      "statut",
      "reponse",
      "slug",
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
        return Str::random(5).' '.Carbon::now()->timestamp;
    }
}
