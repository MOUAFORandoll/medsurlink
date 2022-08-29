<?php

namespace App\Models;

use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

/**
 * App\Models\ExamenClinic
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
 * @method static \Illuminate\Database\Eloquent\Builder|ExamenClinic findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamenClinic newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ExamenClinic newQuery()
 * @method static \Illuminate\Database\Query\Builder|ExamenClinic onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ExamenClinic query()
 * @method static \Illuminate\Database\Eloquent\Builder|ExamenClinic whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamenClinic whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamenClinic whereEnDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamenClinic whereFrDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamenClinic whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamenClinic whereReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamenClinic whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamenClinic whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|ExamenClinic withTrashed()
 * @method static \Illuminate\Database\Query\Builder|ExamenClinic withoutTrashed()
 * @mixin \Eloquent
 */
class ExamenClinic extends Model
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
}
