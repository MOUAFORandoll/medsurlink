<?php

namespace App\Models;

use App\Models\Traits\SlugRoutable;
use App\Scopes\RestrictArchievedAt;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Netpok\Database\Support\RestrictSoftDeletes;
use App\Scopes\RestrictConsultationObstetriqueScope;

/**
 * App\Models\ConsultationPrenatale
 *
 * @property int $id
 * @property int $consultation_obstetrique_id
 * @property string $date_creation
 * @property string $type_de_consultation
 * @property string|null $plaintes
 * @property string|null $recommandations
 * @property string|null $examen_clinique
 * @property string|null $examen_complementaire
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $slug
 * @property string|null $archieved_at
 * @property string|null $passed_at
 * @property-read \App\Models\ConsultationObstetrique $consultationObstetrique
 * @property-read mixed $type_de_consultation_and_timestamp
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ParametreObstetrique[] $parametresObstetrique
 * @property-read int|null $parametres_obstetrique_count
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationPrenatale findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationPrenatale newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationPrenatale newQuery()
 * @method static \Illuminate\Database\Query\Builder|ConsultationPrenatale onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationPrenatale query()
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationPrenatale whereArchievedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationPrenatale whereConsultationObstetriqueId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationPrenatale whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationPrenatale whereDateCreation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationPrenatale whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationPrenatale whereExamenClinique($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationPrenatale whereExamenComplementaire($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationPrenatale whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationPrenatale wherePassedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationPrenatale wherePlaintes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationPrenatale whereRecommandations($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationPrenatale whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationPrenatale whereTypeDeConsultation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationPrenatale whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|ConsultationPrenatale withTrashed()
 * @method static \Illuminate\Database\Query\Builder|ConsultationPrenatale withoutTrashed()
 * @mixin \Eloquent
 */
class ConsultationPrenatale extends Model
{
    use SoftDeletes;
    use RestrictSoftDeletes;
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
                'source' => 'TypeDeConsultationAndTimestamp'
            ]
        ];
    }
    public function getTypeDeConsultationAndTimestampAttribute() {
        return $this->type_de_consultation . ' ' .Carbon::now()->timestamp;
    }
    /**
     * The relations restricting model deletion
     */
    protected $restrictDeletes = [''];

    protected $fillable = [
        "consultation_obstetrique_id",
        "type_de_consultation",
        "plaintes",
        "recommandations",
        'archieved_at',
        'passed_at',
        'slug',
        "examen_clinique",
        "examen_complementaire",
        "ligne_de_temps_id"
    ];

    public function parametresObstetrique(){
        return $this->hasMany(ParametreObstetrique::class,'consultation_prenatale_id','id');
    }

    public function consultationObstetrique(){
        return $this->belongsTo(ConsultationObstetrique::class,'consultation_obstetrique_id','id');
    }
    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new RestrictConsultationObstetriqueScope);
        static::addGlobalScope(new RestrictArchievedAt);
    }

    public function updatePrenatalConsultation(){
        if (!is_null($this)){
            $dossier = $this->consultationObstetrique->dossier;
            $user = $dossier->patient->user;
            $this['user']=$user;
            $this['dossier']=$dossier;
            $isAuthor = checkIfIsAuthorOrIsAuthorized("ConsultationPrenatale",$this->id,"create");
            $this['author'] = getAuthor("ConsultationPrenatale",$this->id,"create");
            $this['isAuthor']=$isAuthor->getOriginalContent();
            $connectedUser = Auth::user();
            if ($connectedUser->getRoleNames()->first() == 'Medecin controle'){
                $this['isAuthor']=true;
            }
        }
    }
}
