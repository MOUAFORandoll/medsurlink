<?php

namespace App\Models;

use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

/**
 * App\Models\Anamnese
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
 * @method static \Illuminate\Database\Eloquent\Builder|Anamnese findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|Anamnese newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Anamnese newQuery()
 * @method static \Illuminate\Database\Query\Builder|Anamnese onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Anamnese query()
 * @method static \Illuminate\Database\Eloquent\Builder|Anamnese whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Anamnese whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Anamnese whereEnDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Anamnese whereFrDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Anamnese whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Anamnese whereReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Anamnese whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Anamnese whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Anamnese withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Anamnese withoutTrashed()
 * @mixin \Eloquent
 */
class Anamnese extends Model
{
    use Sluggable;
    use SoftDeletes;
    protected $table = 'anamneses';
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
