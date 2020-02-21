<?php

namespace App\Models;

use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class File extends Model
{
    use SoftDeletes;
    use Sluggable;

    protected $fillable = [
        "fileable_id",
        "fileable_type",
        "nom",
        "extension",
        "chemin",
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
        return $this->nom . ' ' .Carbon::now()->timestamp;
    }

    public function fileable(){
            return $this->morphTo();
    }


}
