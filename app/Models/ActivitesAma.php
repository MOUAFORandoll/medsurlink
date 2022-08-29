<?php

namespace App\Models;

use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use App\Models\ActiviteAmaPatient;

/**
 * App\Models\ActivitesAma
 *
 * @property int $id
 * @property string $description_fr
 * @property string $description_en
 * @property string|null $type
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|ActiviteAmaPatient[] $activites
 * @property-read int|null $activites_count
 * @property-read mixed $dossier_and_timestamp
 * @method static \Illuminate\Database\Eloquent\Builder|ActivitesAma findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|ActivitesAma newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ActivitesAma newQuery()
 * @method static \Illuminate\Database\Query\Builder|ActivitesAma onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ActivitesAma query()
 * @method static \Illuminate\Database\Eloquent\Builder|ActivitesAma whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActivitesAma whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActivitesAma whereDescriptionEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActivitesAma whereDescriptionFr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActivitesAma whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActivitesAma whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActivitesAma whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActivitesAma whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|ActivitesAma withTrashed()
 * @method static \Illuminate\Database\Query\Builder|ActivitesAma withoutTrashed()
 * @mixin \Eloquent
 */
class ActivitesAma extends Model
{
    use Sluggable;
    use SoftDeletes;
    protected $table = 'activites_ama';
    protected $fillable = [
        "fr_description",
        "en_description",
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

    public function activites(){
        return $this->hasMany(ActiviteAmaPatient::class,'activite_ama_id','id');
    }
}
