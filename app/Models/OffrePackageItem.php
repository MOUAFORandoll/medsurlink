<?php

namespace App\Models;

use App\Models\Traits\SlugRoutable;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\OffrePackageItem
 *
 * @property int $id
 * @property int|null $package_id
 * @property int|null $key
 * @property string|null $reference
 * @property string|null $value
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Dictionnaire|null $item
 * @property-read \App\Models\Package|null $packages
 * @method static \Illuminate\Database\Eloquent\Builder|OffrePackageItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OffrePackageItem newQuery()
 * @method static \Illuminate\Database\Query\Builder|OffrePackageItem onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|OffrePackageItem query()
 * @method static \Illuminate\Database\Eloquent\Builder|OffrePackageItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OffrePackageItem whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OffrePackageItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OffrePackageItem whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OffrePackageItem wherePackageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OffrePackageItem whereReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OffrePackageItem whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OffrePackageItem whereValue($value)
 * @method static \Illuminate\Database\Query\Builder|OffrePackageItem withTrashed()
 * @method static \Illuminate\Database\Query\Builder|OffrePackageItem withoutTrashed()
 * @mixin \Eloquent
 */
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
