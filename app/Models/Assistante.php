<?php

namespace App\Models;

use App\User;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

/**
 * App\Models\Assistante
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $creator
 * @property int|null $etablissement_id
 * @property string $sexe
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\EtablissementExercice|null $etablissements
 * @property-read mixed $reference_and_timestamp
 * @property-read User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|Assistante findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|Assistante newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Assistante newQuery()
 * @method static \Illuminate\Database\Query\Builder|Assistante onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Assistante query()
 * @method static \Illuminate\Database\Eloquent\Builder|Assistante whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Assistante whereCreator($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Assistante whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Assistante whereEtablissementId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Assistante whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Assistante whereSexe($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Assistante whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Assistante whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Assistante whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|Assistante withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Assistante withoutTrashed()
 * @mixin \Eloquent
 */
class Assistante extends Model
{
    use SoftDeletes;
    use Sluggable;

    protected $fillable = ['user_id','etablissement_id','sexe','slug'];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'ReferenceAndTimestamp'
            ]
        ];
    }

    public static function boot()
    {
        parent::boot(); // TODO: Change the autogenerated stub

        Assistante::creating(function ($assistante){

            $assistante->creator = Auth::id();
        });

    }

    public function getReferenceAndTimestampAttribute() {
        return Str::random(6) . ' ' .Carbon::now()->timestamp;
    }

    public function etablissements(){
        return $this->belongsTo(EtablissementExercice::class,'etablissement_id','id');
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id','id')->withTrashed();
    }

}
