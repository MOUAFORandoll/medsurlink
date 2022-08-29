<?php

namespace App\Models;

use App\Models\Traits\SlugRoutable;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Offre
 *
 * @property int $id
 * @property string|null $description_fr
 * @property string|null $description_en
 * @property string|null $status
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Dictionnaire[] $items
 * @property-read int|null $items_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Package[] $packages
 * @property-read int|null $packages_count
 * @method static \Illuminate\Database\Eloquent\Builder|Offre findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|Offre newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Offre newQuery()
 * @method static \Illuminate\Database\Query\Builder|Offre onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Offre query()
 * @method static \Illuminate\Database\Eloquent\Builder|Offre whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Offre whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Offre whereDescriptionEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Offre whereDescriptionFr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Offre whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Offre whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Offre whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Offre whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Offre withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Offre withoutTrashed()
 * @mixin \Eloquent
 */
class Offre extends Model
{
    use SoftDeletes;
    use Sluggable;
    use SluggableScopeHelpers;
    use SlugRoutable;
    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'ReferenceAndTimestamp'
            ]
        ];
    }

    protected $fillable = [
        "description_fr",
        "description_en",
        'slug'
    ];
    public  function  packages(){
        return $this->hasMany(Package::class,'offre_id','id');
    }
    public  function  items(){
        return $this->hasMany(Dictionnaire::class,'reference','slug');
    }
}
