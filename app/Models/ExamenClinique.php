<?php

namespace App\Models;

use App\Models\Traits\SlugRoutable;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExamenClinique extends Model
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
                'source' => 'ReferenceAndTimestamp'
            ]
        ];
    }
    public function getReferenceAndTimestampAttribute() {
        return $this->reference . ' ' .Carbon::now()->timestamp;
    }
    protected $fillable = [
        "reference",
        "description",
        'slug'
    ];

    public  function  consultations(){
        return $this->belongsToMany(ConsultationMedecineGenerale::class,'consultation_clinique','examen_clinique_id','consultation_medecine_generale_id');
    }

    public function consultationPrenatale(){
        return $this->belongsToMany(ConsultationPrenatale::class,'consult_pren_exam_clin','examen_clinique_id','consultation_prenatale_id');
    }

    public function hospitalisation(){
        return $this->belongsToMany(Hospitalisation::class,'hospitalisation_exam_clin','examen_clinique_id','hospitalisation_id');
    }
}
