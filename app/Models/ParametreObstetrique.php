<?php

namespace App\Models;

use App\Models\Traits\SlugRoutable;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ParametreObstetrique extends Model
{
    use SoftDeletes;
    use Sluggable;
    use SluggableScopeHelpers;
    use SlugRoutable;
    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'ConsultationAndTimestamp'
            ]
        ];
    }
    public function getConsultationAndTimestampAttribute() {
        return $this->consultationPrenatale->slug . ' ' .Carbon::now()->timestamp;
    }
    protected $table = "parametre_obs";
    protected $fillable = [
        "consultation_prenatale_id",
        "poids",
        "ta_systolique",
        "ta_diastolique",
        "hauteur_urine",
        "toucher_vaginal",
        "bruit_du_coeur",
        'slug'
    ];

    public function consultationPrenatale(){
        return $this->belongsTo(ConsultationPrenatale::class,'consultation_prenatale_id','id');
    }
}
