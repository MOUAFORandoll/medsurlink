<?php

namespace App\Models;

use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DelaiOperation extends Model
{
    use Sluggable;
    use SoftDeletes;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'delai_operations';

    protected $fillable = [
        "patient_id",
        "delai_operationable_id",
        "delai_operationable_type",
        "date_heure_prevue",
        "date_heure_effectif",
        "observation",
        "slug",
    ];


    public function getPatientIdAndTimestampAttribute() {
        return $this->patient_id.' '.Carbon::now()->timestamp;
    }

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'patientIdAndTimestamp'
            ]
        ];
    }

    public function patient(){
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    public function type_observation(){
        return $this->belongsTo(TypeOperation::class);
    }

    public function delai_operationable()
    {
        return $this->morphTo();
    }
}
