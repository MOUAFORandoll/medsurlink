<?php

namespace App\Models;

use App\User;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

/**
 * App\Models\MedecinAvis
 *
 * @property int $id
 * @property int $avis_id
 * @property int $medecin_id
 * @property string $slug
 * @property int $view
 * @property string|null $avis
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $set_opinion_at
 * @property string|null $statut
 * @property-read \App\Models\Avis $avisMedecin
 * @property-read mixed $name_and_timestamp
 * @property-read User $medecin
 * @method static \Illuminate\Database\Eloquent\Builder|MedecinAvis findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|MedecinAvis newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MedecinAvis newQuery()
 * @method static \Illuminate\Database\Query\Builder|MedecinAvis onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|MedecinAvis query()
 * @method static \Illuminate\Database\Eloquent\Builder|MedecinAvis whereAvis($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedecinAvis whereAvisId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedecinAvis whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedecinAvis whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedecinAvis whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedecinAvis whereMedecinId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedecinAvis whereSetOpinionAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedecinAvis whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedecinAvis whereStatut($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedecinAvis whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedecinAvis whereView($value)
 * @method static \Illuminate\Database\Query\Builder|MedecinAvis withTrashed()
 * @method static \Illuminate\Database\Query\Builder|MedecinAvis withoutTrashed()
 * @mixin \Eloquent
 */
class MedecinAvis extends Model
{
    use SoftDeletes;
    use Sluggable;


    protected $fillable = [
        "avis_id",
        "medecin_id",
        "view",
        "avis",
        "set_opinion_at",
        "slug",
        "statut",
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
                'source' => 'NameAndTimestamp'
            ]
        ];
    }

    public function getNameAndTimestampAttribute() {
        return Str::random(16).' '.Carbon::now()->timestamp;
    }

    public function avisMedecin(){
        return $this->belongsTo(Avis::class,'avis_id','id');
    }

    public function medecin(){
        return $this->belongsTo(User::class,'medecin_id','id');
    }
}
