<?php

namespace App\Models;

use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TypeOperation extends Model
{
    use Sluggable;
    use SoftDeletes;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'type_operations';



    protected $fillable = [
        "libelle",
        "slug",
    ];

    public function getTypeAndTimestampAttribute() {
        return $this->libelle.' '.Carbon::now()->timestamp;
    }

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'TypeAndTimestamp'
            ]
        ];
    }

    public function delai_operations(){
        return $this->hasMany(DelaiOperation::class);
    }


}
