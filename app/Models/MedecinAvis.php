<?php

namespace App\Models;

use App\User;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class MedecinAvis extends Model
{
    use SoftDeletes;
    use Sluggable;


    protected $fillable = [
        "avis_id",
        "medecin_id",
        "view",
        "avis",
        "slug",
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
                'source' => 'NameAndTimestamp'
            ]
        ];
    }

    public function getNameAndTimestampAttribute() {
        return Str::random(16).' '.Carbon::now()->timestamp;
    }

    public function avis(){
        return $this->belongsTo(Avis::class,'avis_id','id');
    }

    public function medecin(){
        return $this->belongsTo(User::class,'medecin_id','id');
    }
}
