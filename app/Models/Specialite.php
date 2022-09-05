<?php

namespace App\Models;

use App\Models\Traits\SlugRoutable;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Netpok\Database\Support\RestrictSoftDeletes;

/**
 * App\Models\Specialite
 *
 * @property int $id
 * @property int $profession_id
 * @property string $name
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $slug
 * @property-read mixed $name_and_timestamp
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\MedecinControle[] $medecinsControle
 * @property-read int|null $medecins_controle_count
 * @property-read \App\Models\Profession $profession
 * @method static \Illuminate\Database\Eloquent\Builder|Specialite findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|Specialite newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Specialite newQuery()
 * @method static \Illuminate\Database\Query\Builder|Specialite onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Specialite query()
 * @method static \Illuminate\Database\Eloquent\Builder|Specialite whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Specialite whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Specialite whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Specialite whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Specialite whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Specialite whereProfessionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Specialite whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Specialite whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Specialite withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Specialite withoutTrashed()
 * @mixin \Eloquent
 */
class Specialite extends Model
{
    use SoftDeletes;
    use RestrictSoftDeletes;
    use Sluggable;
    use SluggableScopeHelpers;
    use SlugRoutable;
    /**
     * The relations restricting model deletion
     */
    protected $restrictDeletes = ['medecinsControle'];

    protected $fillable = [
        "name",
        "description",
        "profession_id",
        'slug'
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
        return $this->name.' '.Carbon::now()->timestamp;
    }

    public function profession(){
        return $this->belongsTo(Profession::class,'profession_id','id');
    }

    public function medecinsControle(){
        return $this->hasMany(MedecinControle::class,'specialite_id','id');
    }
}
