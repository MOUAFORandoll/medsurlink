<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\ActivitesMedecinReferent
 *
 * @property int $id
 * @property string $description_fr
 * @property string $description_en
 * @property string $type
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ActivitesControle[] $activites
 * @property-read int|null $activites_count
 * @property-read mixed $dossier_and_timestamp
 * @method static \Illuminate\Database\Eloquent\Builder|ActivitesMedecinReferent findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|ActivitesMedecinReferent newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ActivitesMedecinReferent newQuery()
 * @method static \Illuminate\Database\Query\Builder|ActivitesMedecinReferent onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ActivitesMedecinReferent query()
 * @method static \Illuminate\Database\Eloquent\Builder|ActivitesMedecinReferent whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActivitesMedecinReferent whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActivitesMedecinReferent whereDescriptionEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActivitesMedecinReferent whereDescriptionFr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActivitesMedecinReferent whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActivitesMedecinReferent whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActivitesMedecinReferent whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActivitesMedecinReferent whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|ActivitesMedecinReferent withTrashed()
 * @method static \Illuminate\Database\Query\Builder|ActivitesMedecinReferent withoutTrashed()
 * @mixin \Eloquent
 */
class ActivitesMedecinReferent extends Model
{
    use Sluggable;
    use SoftDeletes;

    protected $table = 'activites_medecin_referent';
    protected $fillable = [
        "description_fr",
        "description_en",
        "type", 
        "slug",
    ];

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
        return $this->hasMany(ActivitesControle::class,'activite_id','id');
    }
}
