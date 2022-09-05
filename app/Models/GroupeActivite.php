<?php

namespace App\Models;

use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

/**
 * App\Models\GroupeActivite
 *
 * @property int $id
 * @property string $nom
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $dossier_and_timestamp
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\GroupeActiviteMission[] $missions
 * @property-read int|null $missions_count
 * @method static \Illuminate\Database\Eloquent\Builder|GroupeActivite findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|GroupeActivite newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|GroupeActivite newQuery()
 * @method static \Illuminate\Database\Query\Builder|GroupeActivite onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|GroupeActivite query()
 * @method static \Illuminate\Database\Eloquent\Builder|GroupeActivite whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GroupeActivite whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GroupeActivite whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GroupeActivite whereNom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GroupeActivite whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GroupeActivite whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|GroupeActivite withTrashed()
 * @method static \Illuminate\Database\Query\Builder|GroupeActivite withoutTrashed()
 * @mixin \Eloquent
 */
class GroupeActivite extends Model
{
    use Sluggable;
    use SoftDeletes;

    protected $fillable = [
      'nom',
      'slug',
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

    public function missions(){
        return $this->hasMany(GroupeActiviteMission::class,'groupe_id','id');
    }
}
