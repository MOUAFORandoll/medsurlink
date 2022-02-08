<?php

namespace App\Models;

use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use App\Models\ActiviteAmaPatient;

class ActivitesAma extends Model
{
    use Sluggable;
    use SoftDeletes;
    protected $table = 'activites_ama';
    protected $fillable = [
        "fr_description",
        "en_description",
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
                'source' => 'DossierAndTimestamp'
            ]
        ];
    }

    public function getDossierAndTimestampAttribute() {
        return Str::random(10) . ' ' .Carbon::now()->timestamp;
    }

    public function activites(){
        return $this->hasMany(ActiviteAmaPatient::class,'activite_ama_id','id');
    }
}
