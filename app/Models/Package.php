<?php

namespace App\Models;

use App\Models\Traits\SlugRoutable;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Package
 *
 * @property int $id
 * @property int $offre_id
 * @property string|null $description_fr
 * @property string|null $description_en
 * @property \Illuminate\Database\Eloquent\Collection|\App\Models\OffrePackageItem[] $items
 * @property string|null $status
 * @property string $montant
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Affiliation[] $affiliations
 * @property-read int|null $affiliations_count
 * @property-read int|null $items_count
 * @method static \Illuminate\Database\Eloquent\Builder|Package newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Package newQuery()
 * @method static \Illuminate\Database\Query\Builder|Package onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Package query()
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereDescriptionEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereDescriptionFr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereItems($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereMontant($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereOffreId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Package withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Package withoutTrashed()
 * @mixin \Eloquent
 */
class Package extends Model
{
    use SoftDeletes;

    protected $table = 'offres_packages';

    protected $fillable = [
        "description_fr",
        "description_en",
        'montant',
        "fake_price",
        'items'
    ];
    public  function  offres(){
        return $this->belongTo(Offre::class,'offre_id','id');
    }
    public  function  items(){
        return $this->hasMany(OffrePackageItem::class,'package_id','id');
    }

    public function affiliations(){
        return $this->hasMany(Affiliation::class);
    }
}
