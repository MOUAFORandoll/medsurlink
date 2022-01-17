<?php

namespace App\Models;

use App\Models\Traits\SlugRoutable;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OffrePackageItem extends Model
{
    use SoftDeletes;

    protected $table = 'offre_package_items';
    protected $fillable = [
        "value",
        "reference",
    ];
    public  function  item(){
        return $this->belongsTo(Dictionnaire::class,'key','id');
    }
    public  function  packages(){
        return $this->belongsTo(Package::class,'package_id','id');
    }
}
