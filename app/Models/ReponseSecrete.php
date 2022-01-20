<?php

namespace App\Models;

use App\User;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReponseSecrete extends Model
{
    use SoftDeletes;
    use Sluggable;

    protected $fillable = [
        'user_id',
        'question_id',
        'reponse',
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
        return substr($this->reponse,0,2) . ' ' . Carbon::now()->timestamp;
    }

    public function question(){
        return $this->belongsTo(Question::class,'question_id','id');
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }

}
