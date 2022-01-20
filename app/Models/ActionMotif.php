<?php

namespace App\Models;

use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ActionMotif extends Model
{
    use Sluggable;
    use SoftDeletes;

    protected $fillable = [
        "actionable_type",
        "actionable_id",
        "slug",
        "motif_id",
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
                'source' => 'ActionAndTimestamp'
            ]
        ];
    }

    public function getActionAndTimestampAttribute()
    {
        return $this->actionable_type .''. Carbon::now()->timestamp;
    }

    public function actionable()
    {
        return $this->morphTo();
    }

    public function motifs(){
        return $this->belongsTo(Motif::class,'motif_id','id');
    }
}
