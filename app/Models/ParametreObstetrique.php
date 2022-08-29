<?php

namespace App\Models;

use App\Models\Traits\SlugRoutable;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\ParametreObstetrique
 *
 * @property int $id
 * @property int $consultation_prenatale_id
 * @property float|null $poids
 * @property int|null $ta_systolique
 * @property int|null $ta_diastolique
 * @property int|null $hauteur_urine
 * @property int|null $toucher_vaginal
 * @property int|null $bruit_du_coeur
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $slug
 * @property-read \App\Models\ConsultationPrenatale $consultationPrenatale
 * @property-read mixed $consultation_and_timestamp
 * @method static \Illuminate\Database\Eloquent\Builder|ParametreObstetrique findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|ParametreObstetrique newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ParametreObstetrique newQuery()
 * @method static \Illuminate\Database\Query\Builder|ParametreObstetrique onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ParametreObstetrique query()
 * @method static \Illuminate\Database\Eloquent\Builder|ParametreObstetrique whereBruitDuCoeur($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParametreObstetrique whereConsultationPrenataleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParametreObstetrique whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParametreObstetrique whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParametreObstetrique whereHauteurUrine($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParametreObstetrique whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParametreObstetrique wherePoids($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParametreObstetrique whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParametreObstetrique whereTaDiastolique($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParametreObstetrique whereTaSystolique($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParametreObstetrique whereToucherVaginal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParametreObstetrique whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|ParametreObstetrique withTrashed()
 * @method static \Illuminate\Database\Query\Builder|ParametreObstetrique withoutTrashed()
 * @mixin \Eloquent
 */
class ParametreObstetrique extends Model
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
                'source' => 'ConsultationAndTimestamp'
            ]
        ];
    }
    public function getConsultationAndTimestampAttribute() {
        return $this->consultationPrenatale->slug . ' ' .Carbon::now()->timestamp;
    }
    protected $table = "parametre_obs";
    protected $fillable = [
        "consultation_prenatale_id",
        "poids",
        "ta_systolique",
        "ta_diastolique",
        "hauteur_urine",
        "toucher_vaginal",
        "bruit_du_coeur",
        'slug'
    ];

    public function consultationPrenatale(){
        return $this->belongsTo(ConsultationPrenatale::class,'consultation_prenatale_id','id');
    }

    public function updateParametreObstetrique(){
        if(!is_null($this)){
            $isAuthor = checkIfIsAuthorOrIsAuthorized("ParametreObstetrique",$this->id,"create");
            $this['isAuthor'] = $isAuthor->getOriginalContent();
        }
    }
}
