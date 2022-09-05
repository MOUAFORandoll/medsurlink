<?php

namespace App\Models;

use App\Models\Traits\SlugRoutable;
use App\Scopes\RestrictArchievedAt;
use App\Scopes\RestrictDossierScope;
use App\User;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Netpok\Database\Support\RestrictSoftDeletes;

/**
 * App\Models\ConsultationObstetrique
 *
 * @property int $id
 * @property int $dossier_medical_id
 * @property string $date_creation
 * @property int $numero_grossesse
 * @property string $ddr
 * @property string|null $antecedent_conjoint
 * @property string|null $serologie
 * @property string|null $groupe_sanguin
 * @property string|null $statut_socio_familiale
 * @property string|null $assuetudes
 * @property string|null $antecedent_de_transfusion
 * @property string|null $facteur_de_risque
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $slug
 * @property string|null $archieved_at
 * @property string|null $passed_at
 * @property string $pcr_gonocoque
 * @property string $pcr_chlamydia
 * @property string $rcc
 * @property string $glycemie
 * @property string $emu
 * @property string $tsh
 * @property string $anti_tpo
 * @property string $ft4
 * @property string $ft3
 * @property string|null $attention
 * @property string|null $info_prise_en_charge
 * @property int|null $etablissement_id
 * @property string $t1
 * @property string $nle_anle
 * @property string $sexe
 * @property int|null $creator
 * @property-read User|null $author
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ConsultationPrenatale[] $consultationPrenatales
 * @property-read int|null $consultation_prenatales_count
 * @property-read \App\Models\DossierMedical $dossier
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Echographie[] $echographies
 * @property-read int|null $echographies_count
 * @property-read \App\Models\EtablissementExercice|null $etablissement
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\File[] $files
 * @property-read int|null $files_count
 * @property-read mixed $dossier_and_timestamp
 * @property-read \App\Models\LigneDeTemps $ligneDeTemps
 * @property-read \App\Models\RendezVous|null $rdv
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationObstetrique findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationObstetrique newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationObstetrique newQuery()
 * @method static \Illuminate\Database\Query\Builder|ConsultationObstetrique onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationObstetrique orderByDateDeRendezVous()
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationObstetrique query()
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationObstetrique whereAntecedentConjoint($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationObstetrique whereAntecedentDeTransfusion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationObstetrique whereAntiTpo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationObstetrique whereArchievedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationObstetrique whereAssuetudes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationObstetrique whereAttention($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationObstetrique whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationObstetrique whereCreator($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationObstetrique whereDateCreation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationObstetrique whereDdr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationObstetrique whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationObstetrique whereDossierMedicalId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationObstetrique whereEmu($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationObstetrique whereEtablissementId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationObstetrique whereFacteurDeRisque($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationObstetrique whereFt3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationObstetrique whereFt4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationObstetrique whereGlycemie($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationObstetrique whereGroupeSanguin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationObstetrique whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationObstetrique whereInfoPriseEnCharge($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationObstetrique whereNleAnle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationObstetrique whereNumeroGrossesse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationObstetrique wherePassedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationObstetrique wherePcrChlamydia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationObstetrique wherePcrGonocoque($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationObstetrique whereRcc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationObstetrique whereSerologie($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationObstetrique whereSexe($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationObstetrique whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationObstetrique whereStatutSocioFamiliale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationObstetrique whereT1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationObstetrique whereTsh($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationObstetrique whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|ConsultationObstetrique withTrashed()
 * @method static \Illuminate\Database\Query\Builder|ConsultationObstetrique withoutTrashed()
 * @mixin \Eloquent
 */
class ConsultationObstetrique extends Model
{
    use SoftDeletes;
    use RestrictSoftDeletes;
    use Sluggable;
    use SluggableScopeHelpers;
    use SlugRoutable;

    /**
     * The relations restricting model deletion
     */
    protected $restrictDeletes = ['consultationPrenatales','echographies'];

    protected $fillable = [
        "dossier_medical_id",
        "date_creation",
        "numero_grossesse",
        "ddr",
        "serologie",
        "groupe_sanguin",
        "statut_socio_familiale",
        "assuetudes",
        "antecassuetudesedent_de_transfusion",
        "facteur_de_risque",
        "antecedent_conjoint",
        'archieved_at',
        'passed_at',
        'slug',
        "pcr_gonocoque",
        "pcr_chlamydia",
        "rcc",
        "glycemie",
        "emu",
        "tsh",
        "anti_tpo",
        "ft4",
        "ft3",
        "attention",
        "info_prise_en_charge",
        "etablissement_id",
        "t1",
        "nle_anle",
        "sexe",
        "creator",
        "ligne_de_temps_id"
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
                'source' => 'DossierAndTimestamp'
            ]
        ];
    }
    public function getDossierAndTimestampAttribute() {
        return $this->dossier->slug . ' ' .Carbon::now()->timestamp;
    }
    public function consultationPrenatales(){
        return $this->hasMany(ConsultationPrenatale::class,'consultation_obstetrique_id','id');
    }
    public function echographies(){
        return $this->hasMany(Echographie::class,'consultation_obstetrique_id','id');
    }

    public function dossier(){
        return $this->belongsTo(DossierMedical::class,'dossier_medical_id','id');
    }
    public function etablissement(){
        return $this->belongsTo(EtablissementExercice::class,'etablissement_id','id');
    }

    public function author (){
        return $this->belongsTo(User::class,'creator','id');
    }
    public function ligneDeTemps(){
        return $this->belongsTo(LigneDeTemps::class,'ligne_de_temps_id','id');
    }
    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new RestrictDossierScope);
        static::addGlobalScope(new RestrictArchievedAt);
    }

    public function updateObstetricConsultation(){
        $user = $this->dossier->patient->user;
        $allergies = $this->dossier->allergies;
        foreach ($allergies as $allergy)
        {
            $allergieIsAuthor = checkIfIsAuthorOrIsAuthorized("Allergie",$allergy->id,"create");
            $allergy['isAuthor'] = $allergieIsAuthor->getOriginalContent();
        }
        $this['allergies']= $allergies;
        $this['user']=$user;
        $isAuthor = checkIfIsAuthorOrIsAuthorized("ConsultationObstetrique",$this->id,"create");
        $canUpdate = checkIfCanUpdated("ConsultationObstetrique",$this->id,"create");
        $author = $this->author;
        if (!is_null($author)){
//            $this['author']['user'] = $author;
        }else{
            unset($this['author']);
            $this['author'] = getAuthor("ConsultationObstetrique",$this->id,"create");
        }
        $this['isAuthor']=$isAuthor->getOriginalContent();
        $connectedUser = Auth::user();
        if ($connectedUser->getRoleNames()->first() == 'Praticien'){
            $this['canUpdate']=$canUpdate->getOriginalContent() && is_null($this->passed_at) && is_null($this->archieved_at);
        }elseif ($connectedUser->getRoleNames()->first() == 'Medecin controle'){
            $this['isAuthor']=true;
            if ($isAuthor->getOriginalContent() == true)
                $this['canUpdate'] = is_null($this->archieved_at);
            else{
                $this['canUpdate']=$canUpdate->getOriginalContent() && !is_null($this->passed_at) && is_null($this->archieved_at);
            }
        }elseif($connectedUser->getRoleNames()->first() == 'Admin'){
            $this['canUpdate']=true;
        }
    }

    public function scopeOrderByDateDeRendezVous($query)
    {
        return $query->orderBy('ddr', 'desc');
    }

    public function files(){
        return $this->morphMany(File::class,'fileable');
    }

    public function rdv(){
        return $this->morphOne(RendezVous::class,'sourceable');
    }
}
