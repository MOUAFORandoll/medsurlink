<?php

namespace App\Models;

use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contributeurs extends Model
{
    use SoftDeletes;
    use Sluggable;

    protected $fillable = [
        "contributable_id",
        "contributable_type",
        "operationable_id",
        "operationable_type",
        "slug",
    ];

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'TypeAndTimestamp'
            ]
        ];
    }

    public function getTypeAndTimestampAttribute() {
        return $this->contributable_type.' '.Carbon::now()->timestamp;
    }

    public function contributable(){
        return $this->morphTo();
    }

    public function operationable(){
        return $this->morphTo();
    }
}
