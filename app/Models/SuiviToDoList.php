<?php

namespace App\Models;

use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class SuiviToDoList extends Model
{
    use SoftDeletes;
    use Sluggable;

    protected $fillable = [
      "listable_type",
      "listable_id",
      "intitule",
      "description",
      "statut",
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
        return Str::random(6) . ' ' . Carbon::now()->timestamp;
    }

    public function listable(){
        return $this->morphTo();
    }
}
