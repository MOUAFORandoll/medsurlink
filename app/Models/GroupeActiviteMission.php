<?php

namespace App\Models;

use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

/**
 * App\Models\GroupeActiviteMission
 *
 * @property int $id
 * @property int $groupe_id
 * @property string $description
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $dossier_and_timestamp
 * @method static \Illuminate\Database\Eloquent\Builder|GroupeActiviteMission findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|GroupeActiviteMission newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|GroupeActiviteMission newQuery()
 * @method static \Illuminate\Database\Query\Builder|GroupeActiviteMission onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|GroupeActiviteMission query()
 * @method static \Illuminate\Database\Eloquent\Builder|GroupeActiviteMission whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GroupeActiviteMission whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GroupeActiviteMission whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GroupeActiviteMission whereGroupeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GroupeActiviteMission whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GroupeActiviteMission whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GroupeActiviteMission whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|GroupeActiviteMission withTrashed()
 * @method static \Illuminate\Database\Query\Builder|GroupeActiviteMission withoutTrashed()
 * @mixin \Eloquent
 */
class GroupeActiviteMission extends Model
{
    use SoftDeletes;
    use Sluggable;

    protected $fillable = [
      'groupe_id',
      'description',
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
}
