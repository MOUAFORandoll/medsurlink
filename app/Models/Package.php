<?php

namespace App\Models;

use App\Models\Traits\SlugRoutable;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Package extends Model
{
    use SoftDeletes;

    protected $table = 'offres_packages';

    protected $fillable = [
        "description_fr",
        "description_en",
        'montant',
        'items'
    ];
    public  function  offres(){
        return $this->belongTo(Offre::class,'offre_id','id');
    }
    public  function  items(){
        return $this->hasMany(OffrePackageItem::class,'package_id','id');
    }
}
