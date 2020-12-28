<?php

namespace App\Models;

use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Prescription extends Model
{
    use SoftDeletes;
    use Sluggable;

    protected $fillable = [
        "ordonance_id",
        "medicament_id",
        "info_comp",
        "date_fin",
        "slug",
    ];

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'NameAndTimestamp'
            ]
        ];
    }

    public function getNameAndTimestampAttribute() {
        return Str::random(10).' '.Carbon::now()->timestamp;
    }

    public function medicament(){
        return $this->belongsTo(Medicament::class,'medicament_id','id');
    }

    public function posology(){
        return $this->hasOne(Posologie::class,'prescription_id','id');
    }

    public function ordonnance(){
        return $this->belongsTo(Ordonance::class,'ordonance_id','id');
    }

}
