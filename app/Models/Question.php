<?php

namespace App\Models;

use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends Model
{
    use SoftDeletes;
    use Sluggable;

    protected $fillable = [
        'intitule',
        'slug',
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
                'source' => 'TypeAndTimestamp'
            ]
        ];
    }

    public function getTypeAndTimestampAttribute() {
        return substr($this->intitule,0,5) . ' ' . Carbon::now()->timestamp;
    }

}
