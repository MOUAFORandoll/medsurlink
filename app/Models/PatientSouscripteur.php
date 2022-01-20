<?php

namespace App\Models;

use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PatientSouscripteur extends Model
{
    use SoftDeletes;
    use Sluggable;

    protected $fillable = [
        "financable_type",
        "financable_id",
        "patient_id",
        "slug",
    ];

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'ConsultationAndTimestamp'
            ]
        ];
    }
    public function getConsultationAndTimestampAttribute() {
        return str_random(6). ' ' .Carbon::now()->timestamp;
    }

    public function financable(){
        return $this->morphTo();
    }

    public function patients(){
        return $this->belongsTo(Patient::class,'patient_id','user_id');
    }
}
