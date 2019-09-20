<?php

namespace App\Models;

use App\Models\Traits\SlugRoutable;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TraitementPropose extends Model
{
    use SoftDeletes;
    use Sluggable;
    use SluggableScopeHelpers;
    use SlugRoutable;

    protected $fillable = [
        "consultation_medecine_generale_id",
        "intitule",
        "description",
        'slug'
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
                'source' => 'IntituleAndTimestamp'
            ]
        ];
    }

    public function getIntituleAndTimestampAttribute()
    {
        return $this->intitule . ' ' . Carbon::now()->timestamp;
    }

    public function consultation()
    {
        return $this->belongsTo(ConsultationMedecineGenerale::class,'consultation_medecine_generale_id');
    }
}
