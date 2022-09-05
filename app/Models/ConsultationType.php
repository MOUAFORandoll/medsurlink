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
 * App\Models\ConsultationType
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
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationType findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationType newQuery()
 * @method static \Illuminate\Database\Query\Builder|ConsultationType onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationType query()
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationType whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationType whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationType whereProfessionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationType whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationType whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|ConsultationType withTrashed()
 * @method static \Illuminate\Database\Query\Builder|ConsultationType withoutTrashed()
 * @mixin \Eloquent
 */
class ConsultationType extends Model
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
