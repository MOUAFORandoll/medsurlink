<?php

namespace App\Models;

use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrdonanceMedicament extends Model
{
    use SoftDeletes;
//    use Sluggable;
//    use SluggableScopeHelpers;

    protected $table = ['ordonance_medicament'];

    protected $fillable = [
        "ordonance_id",
        "medicament_id",
    ];

//    public function sluggable()
//    {
//        return [
//            'slug' => [
//                'source' => 'Medoc'
//            ]
//        ];
//    }
//
//    public function getMedocAttribute() {
//        return $this->ordonance->slug.''.Carbon::now()->timestamp;
//    }

    public function ordonance(){
        return $this->belongsTo(Ordonance::class,'ordonance_id','id');
    }
    public function medicament(){
        return $this->belongsTo(Medicament::class,'medicament_id','id');
    }
}
