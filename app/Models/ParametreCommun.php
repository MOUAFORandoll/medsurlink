<?php

namespace App\Models;

use App\Models\Traits\SlugRoutable;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

/**
 * App\Models\ParametreCommun
 *
 * @property int $id
 * @property int|null $consultation_medecine_generale_id
 * @property float|null $poids
 * @property float|null $taille
 * @property float|null $bmi
 * @property int|null $ta_systolique
 * @property int|null $ta_diastolique
 * @property float|null $temperature
 * @property int|null $frequence_cardiaque
 * @property int|null $frequence_respiratoire
 * @property int|null $sato2
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $slug
 * @property string|null $perimetre_abdominal
 * @property string|null $communable_type
 * @property int|null $communable_id
 * @property int|null $ta_systolique_d
 * @property int|null $ta_diastolique_d
 * @property-read Model|\Eloquent $communable
 * @property-read \App\Models\ConsultationMedecineGenerale|null $consultation
 * @property-read mixed $consultation_and_timestamp
 * @method static \Illuminate\Database\Eloquent\Builder|ParametreCommun findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|ParametreCommun newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ParametreCommun newQuery()
 * @method static \Illuminate\Database\Query\Builder|ParametreCommun onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ParametreCommun query()
 * @method static \Illuminate\Database\Eloquent\Builder|ParametreCommun whereBmi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParametreCommun whereCommunableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParametreCommun whereCommunableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParametreCommun whereConsultationMedecineGeneraleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParametreCommun whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParametreCommun whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParametreCommun whereFrequenceCardiaque($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParametreCommun whereFrequenceRespiratoire($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParametreCommun whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParametreCommun wherePerimetreAbdominal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParametreCommun wherePoids($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParametreCommun whereSato2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParametreCommun whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParametreCommun whereTaDiastolique($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParametreCommun whereTaDiastoliqueD($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParametreCommun whereTaSystolique($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParametreCommun whereTaSystoliqueD($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParametreCommun whereTaille($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParametreCommun whereTemperature($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParametreCommun whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|ParametreCommun withTrashed()
 * @method static \Illuminate\Database\Query\Builder|ParametreCommun withoutTrashed()
 * @mixin \Eloquent
 */
class ParametreCommun extends Model
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
        return str_random(6). ' ' .Carbon::now()->timestamp;
    }
    protected $fillable = [
        "consultation_medecine_generale_id",
        "poids",
        "taille",
        "bmi",
        "ta_systolique",
        "ta_systolique_d",
        "ta_diastolique",
        "ta_diastolique_d",
        "temperature",
        "frequence_cardiaque",
        "frequence_respiratoire",
        "sato2",
        "perimetre_abdominal",
        'slug',
        'communable_type',
        'communable_id',
    ];

    public function consultation(){
        return $this->belongsTo(ConsultationMedecineGenerale::class,'consultation_medecine_generale_id','id');
    }

    public function updateParametreCommun(){
        if (!is_null($this)){
            $isAuthor = checkIfIsAuthorOrIsAuthorized("ParametreCommun",$this->id,"create");
            $canUpdate = checkIfCanUpdated("ParametreCommun",$this->id,"create");
            $connectedUser = Auth::user();
            if ($connectedUser->getRoleNames()->first() == 'Praticien'){
                $this['canUpdate']=$canUpdate->getOriginalContent();
            }elseif ($connectedUser->getRoleNames()->first() == 'Medecin controle'){
                if ($isAuthor->getOriginalContent() == true)
                    $this['canUpdate'] = true;
                else{
                    $this['canUpdate']=$canUpdate->getOriginalContent() ;
                }
            }elseif($connectedUser->getRoleNames()->first() == 'Admin'){
                $this['canUpdate']=true;
            }
            $this['isAuthor'] = $isAuthor->getOriginalContent();
            $consultation = !is_null($this->consultation) ? $this->consultation : $this->communable;
            $this['user'] = $consultation->dossier->patient->user;
            $this['dossier'] = $consultation->dossier;
            $this['consultation']  = $consultation;
//            $this['consultation']['dossier']  = $consultation->dossier;
        }
    }

    public function communable(){
        return $this->morphTo();
    }
}
