<?php

namespace App\Models;

use App\User;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Psy\Util\Str;

/**
 * App\Models\MedecinDeSuivi
 *
 * @property int $id
 * @property int $user_id
 * @property int $suivi_id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $dossier_and_timestamp
 * @property-read User $praticien
 * @property-read \App\Models\Suivi $suivi
 * @method static \Illuminate\Database\Eloquent\Builder|MedecinDeSuivi findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|MedecinDeSuivi newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MedecinDeSuivi newQuery()
 * @method static \Illuminate\Database\Query\Builder|MedecinDeSuivi onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|MedecinDeSuivi query()
 * @method static \Illuminate\Database\Eloquent\Builder|MedecinDeSuivi whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedecinDeSuivi whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedecinDeSuivi whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedecinDeSuivi whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedecinDeSuivi whereSuiviId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedecinDeSuivi whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedecinDeSuivi whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|MedecinDeSuivi withTrashed()
 * @method static \Illuminate\Database\Query\Builder|MedecinDeSuivi withoutTrashed()
 * @mixin \Eloquent
 */
class MedecinDeSuivi extends Model
{
    use SoftDeletes;
    use Sluggable;

    protected $fillable = ['user_id','suivi_id','slug'];

    public function sluggable()
    {
        return [
            'slug' => [
                'source' =>'DossierAndTimestamp'
            ]
        ];
    }

    public function getDossierAndTimestampAttribute() {
        return \Illuminate\Support\Str::random(6) . ' ' .Carbon::now()->timestamp;
    }

    public function suivi(){
        return $this->belongsTo(Suivi::class,'suivi_id','id');
    }

    public function praticien(){
        return $this->belongsTo(User::class,'user_id','id');
    }
}
