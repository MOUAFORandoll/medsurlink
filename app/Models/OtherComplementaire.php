<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\OtherComplementaire
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
 * @method static \Illuminate\Database\Eloquent\Builder|OtherComplementaire findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|OtherComplementaire newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OtherComplementaire newQuery()
 * @method static \Illuminate\Database\Query\Builder|OtherComplementaire onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|OtherComplementaire query()
 * @method static \Illuminate\Database\Eloquent\Builder|OtherComplementaire whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OtherComplementaire whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OtherComplementaire whereEnDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OtherComplementaire whereFrDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OtherComplementaire whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OtherComplementaire whereReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OtherComplementaire whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OtherComplementaire whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|OtherComplementaire withTrashed()
 * @method static \Illuminate\Database\Query\Builder|OtherComplementaire withoutTrashed()
 * @mixin \Eloquent
 */
class OtherComplementaire extends Model
{
    use Sluggable;
    use SoftDeletes;
    protected $table = 'other_complementaire';
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
