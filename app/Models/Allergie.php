<?php

namespace App\Models;

use App\Models\Traits\SlugRoutable;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Allergie extends Model
{
    use SoftDeletes;
    use Sluggable;
    use SluggableScopeHelpers;
    use SlugRoutable;
    protected $fillable = [
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
    public function getIntituleAndTimestampAttribute() {
        return $this->intitule . ' ' .Carbon::now()->timestamp;
    }

    public  function  consultations(){
        return $this->belongsToMany(ConsultationMedecineGenerale::class,'consultation_allergie','allergie_id','consultation_medecine_generale_id');
    }
}
