<?php

namespace App\Models;

use App\Models\Traits\SlugRoutable;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Conclusion
 *
 * @property int $id
 * @property int $consultation_medecine_generale_id
 * @property string|null $reference
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string $slug
 * @property-read \App\Models\ConsultationMedecineGenerale $consultationMedecine
 * @property-read mixed $reference_and_timestamp
 * @method static \Illuminate\Database\Eloquent\Builder|Conclusion findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|Conclusion newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Conclusion newQuery()
 * @method static \Illuminate\Database\Query\Builder|Conclusion onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Conclusion query()
 * @method static \Illuminate\Database\Eloquent\Builder|Conclusion whereConsultationMedecineGeneraleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Conclusion whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Conclusion whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Conclusion whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Conclusion whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Conclusion whereReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Conclusion whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Conclusion whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Conclusion withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Conclusion withoutTrashed()
 * @mixin \Eloquent
 */
class Conclusion extends Model
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
                'source' => 'ReferenceAndTimestamp'
            ]
        ];
    }
    public function getReferenceAndTimestampAttribute() {
        return $this->reference . ' ' .Carbon::now()->timestamp;
    }
    protected $fillable = [
        "consultation_medecine_generale_id",
        "reference",
        "description",
        'slug'
    ];

    public function consultationMedecine(){
        return $this->belongsTo(ConsultationMedecineGenerale::class,'consultation_medecine_generale_id','id');
    }

    public function updateConclusionItem(){
        if(!is_null($this)) {
            $isAuthor = checkIfIsAuthorOrIsAuthorized("Conclusion", $this->id, "create");
            $this['isAuthor'] = $isAuthor->getOriginalContent();
            $this['user'] = $this->consultationMedecine->dossier->patient->user;
            $this['dossier'] = $this->consultationMedecine->dossier;
        }
    }
}
