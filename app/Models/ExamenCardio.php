<?php

namespace App\Models;

use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExamenCardio extends Model
{
    use Sluggable;
    use SoftDeletes;

    protected $fillable = [
        "cardiologie_id",
        "nom",
        "date_examen",
        "description",
        "slug",
    ];

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'NomAndTimestamp'
            ]
        ];
    }

    public function getNomAndTimestampAttribute() {
        return $this->nom . ' ' .Carbon::now()->timestamp;
    }

    public function cardiologie(){
        return $this->belongsTo(Cardiologie::class,'cardiologie_id','id');
    }
}
