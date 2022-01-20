<?php

namespace App\Models;

use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Categories extends Model
{
    use SoftDeletes;
    use Sluggable;

    protected $fillable = ['nom','icon','slug'];

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'NameAndTimestamp'
            ]
        ];
    }

    public function getNameAndTimestampAttribute() {
        return Str::random(5).' '.Carbon::now()->timestamp;
    }

    public function suivis(){
        return $this->hasMany(Suivi::class,'categorie_id','id');
    }
}
