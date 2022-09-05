<?php

namespace App\Models;

use App\Models\Traits\SlugRoutable;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\TraitementPropose
 *
 * @property int $id
 * @property int $consultation_medecine_generale_id
 * @property string $slug
 * @property string $intitule
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\ConsultationMedecineGenerale $consultation
 * @property-read mixed $intitule_and_timestamp
 * @method static \Illuminate\Database\Eloquent\Builder|TraitementPropose findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|TraitementPropose newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TraitementPropose newQuery()
 * @method static \Illuminate\Database\Query\Builder|TraitementPropose onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|TraitementPropose query()
 * @method static \Illuminate\Database\Eloquent\Builder|TraitementPropose whereConsultationMedecineGeneraleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TraitementPropose whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TraitementPropose whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TraitementPropose whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TraitementPropose whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TraitementPropose whereIntitule($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TraitementPropose whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TraitementPropose whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|TraitementPropose withTrashed()
 * @method static \Illuminate\Database\Query\Builder|TraitementPropose withoutTrashed()
 * @mixin \Eloquent
 */
class TraitementPropose extends Model
{
    use SoftDeletes;
    use Sluggable;
    use SluggableScopeHelpers;
    use SlugRoutable;

    protected $fillable = [
        "consultation_medecine_generale_id",
        "intitule",
        "description",
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
                'source' => 'IntituleAndTimestamp'
            ]
        ];
    }

    public function getIntituleAndTimestampAttribute()
    {
        return $this->intitule . ' ' . Carbon::now()->timestamp;
    }

    public function consultation()
    {
        return $this->belongsTo(ConsultationMedecineGenerale::class,'consultation_medecine_generale_id');
    }
}
