<?php

namespace App\Models;

use App\Models\Traits\SlugRoutable;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Netpok\Database\Support\RestrictSoftDeletes;

class ConsultationObstetrique extends Model
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
                'source' => 'DdrAndTimestamp'
            ]
        ];
    }
    public function getDdrAndTimestampAttribute() {
        return $this->ddr . ' ' .Carbon::now()->timestamp;
    }
    /**
     * The relations restricting model deletion
     */
    protected $restrictDeletes = ['consultationPrenatales','echographies'];

    protected $fillable = [
        "date_creation",
        "numero_grossesse",
        "ddr",
        "serologie",
        "groupe_sanguin",
        "statut_socio_familiale",
        "assuetudes",
        "antecassuetudesedent_de_transfusion",
        "facteur_de_risque",
        'archieved_at',
        'passed_at',
        'slug'
    ];

    public function consultationPrenatales(){
        return $this->hasMany(ConsultationPrenatale::class,'consultation_obstetrique_id','id');
    }
    public function echographies(){
        return $this->hasMany(Echographie::class,'consultation_obstetrique_id','id');
    }
}
