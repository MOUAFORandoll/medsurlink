<?php

namespace App\Models;

use App\Models\Traits\SlugRoutable;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Netpok\Database\Support\RestrictSoftDeletes;

class ConsultationPrenatale extends Model
{
    use SoftDeletes;
    use RestrictSoftDeletes;
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
                'source' => 'TypeDeConsultationAndTimestamp'
            ]
        ];
    }
    public function getTypeDeConsultationAndTimestampAttribute() {
        return $this->type_de_consultation . ' ' .Carbon::now()->timestamp;
    }
    /**
     * The relations restricting model deletion
     */
    protected $restrictDeletes = ['parametreObstetrique','examensClinique','examensComplementaire'];

    protected $fillable = [
        "consultation_obstetrique_id",
        "type_de_consultation",
        "plaintes",
        "antecedent_conjoint",
        "recommandations",
        'archieved_at',
        'passed_at',
        'slug'
    ];

    public function parametresObstetrique(){
        return $this->hasMany(ParametreObstetrique::class,'consultation_prenatale_id','id');
    }

    public function consultationObstetrique(){
        return $this->belongsTo(ConsultationObstetrique::class,'consultation_obstetrique_id','id');
    }

    public function examensClinique(){
        return $this->belongsToMany(ExamenClinique::class,'consult_pren_exam_clin','consultation_prenatale_id','examen_clinique_id');
    }

    public function examensComplementaire(){
        return $this->belongsToMany(ExamenComplementaire::class,'consult_pren_exam_com','consultation_prenatale_id','examen_complementaire_id');
    }

}
