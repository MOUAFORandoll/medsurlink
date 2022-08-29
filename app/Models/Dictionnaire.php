<?php

namespace App\Models;

use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

/**
 * App\Models\Dictionnaire
 *
 * @property int $id
 * @property string|null $fr_description
 * @property string|null $en_description
 * @property string|null $reference
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $dossier_and_timestamp
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\OffrePackageItem[] $packages
 * @property-read int|null $packages_count
 * @method static \Illuminate\Database\Eloquent\Builder|Dictionnaire findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|Dictionnaire newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Dictionnaire newQuery()
 * @method static \Illuminate\Database\Query\Builder|Dictionnaire onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Dictionnaire query()
 * @method static \Illuminate\Database\Eloquent\Builder|Dictionnaire whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dictionnaire whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dictionnaire whereEnDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dictionnaire whereFrDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dictionnaire whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dictionnaire whereReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dictionnaire whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dictionnaire whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Dictionnaire withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Dictionnaire withoutTrashed()
 * @mixin \Eloquent
 */
class Dictionnaire extends Model
{
    use Sluggable;
    use SoftDeletes;

    protected $fillable = [
        "fr_description",
        "en_description",
        "reference",
        "slug",
    ];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'DossierAndTimestamp'
            ]
        ];
    }

    public function getDossierAndTimestampAttribute() {
        return Str::random(10) . ' ' .Carbon::now()->timestamp;
    }
    public  function  packages(){
        return $this->hasMany(OffrePackageItem::class,'key','id');
    }
}
