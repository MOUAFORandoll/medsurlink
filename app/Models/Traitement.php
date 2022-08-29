<?php

namespace App\Models;

use App\Models\Traits\SlugRoutable;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Traitement
 *
 * @property int $id
 * @property string $intitule
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $slug
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ConsultationMedecineGenerale[] $consultations
 * @property-read int|null $consultations_count
 * @property-read mixed $intitule_and_timestamp
 * @method static \Illuminate\Database\Eloquent\Builder|Traitement findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|Traitement newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Traitement newQuery()
 * @method static \Illuminate\Database\Query\Builder|Traitement onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Traitement query()
 * @method static \Illuminate\Database\Eloquent\Builder|Traitement whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Traitement whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Traitement whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Traitement whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Traitement whereIntitule($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Traitement whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Traitement whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Traitement withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Traitement withoutTrashed()
 * @mixin \Eloquent
 */
class Traitement extends Model
{
    use SoftDeletes;
    use Sluggable;
    use SluggableScopeHelpers;
    use SlugRoutable;
    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'IntituleAndTimestamp'
            ]
        ];
    }
    public function getIntituleAndTimestampAttribute() {
        return $this->intitule . ' ' .Carbon::now()->timestamp;
    }
    protected $fillable = [
        "intitule",
        "description",
        'slug'
    ];

    public  function  consultations(){
        return $this->belongsToMany(ConsultationMedecineGenerale::class,'consult_traitement','traitement_id','consultation_medecine_generale_id');
    }
}
