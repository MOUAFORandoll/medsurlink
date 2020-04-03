<?php

namespace App\Models;

use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Posologie extends Model
{
    use SoftDeletes;
    use Sluggable;

    protected $fillable = [
        "prescription_id",
        "dose",
        "formulation",
        "voieAdmin",
        "nombre",
        "par",
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

    public function prescription(){
        return $this->belongsTo(Prescription::class,'prescription_id','id');
    }
}
