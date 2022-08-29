<?php

namespace App\Models;

use App\Scopes\RestrictArchieved;
use App\Scopes\RestrictArchievedAt;
use App\User;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

/**
 * App\Models\Cardiologie
 *
 * @property int $id
 * @property int $etablissement_id
 * @property int $dossier_medical_id
 * @property string|null $date_consultation
 * @property string|null $anamnese
 * @property string|null $facteur_de_risque
 * @property string|null $profession
 * @property string|null $situation_familiale
 * @property string $nbre_enfant
 * @property string $tabac
 * @property string $alcool
 * @property string|null $autres
 * @property string|null $conclusion
 * @property string|null $conduite_a_tenir
 * @property string|null $examen_clinique
 * @property string|null $rendez_vous
 * @property string|null $archieved_at
 * @property string|null $passed_at
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string $nbreAnnee
 * @property string $nbreCigarette
 * @property int|null $creator
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ActionMotif[] $actions
 * @property-read int|null $actions_count
 * @property-read User|null $author
 * @property-read \App\Models\DossierMedical $dossier
 * @property-read \App\Models\EtablissementExercice $etablissement
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ExamenCardio[] $examenCardios
 * @property-read int|null $examen_cardios_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\File[] $files
 * @property-read int|null $files_count
 * @property-read mixed $dossier_and_timestamp
 * @property-read \App\Models\LigneDeTemps $ligneDeTemps
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Contributeurs[] $operationables
 * @property-read int|null $operationables_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ParametreCommun[] $parametresCommun
 * @property-read int|null $parametres_commun_count
 * @property-read \App\Models\RendezVous|null $rdv
 * @method static \Illuminate\Database\Eloquent\Builder|Cardiologie findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|Cardiologie newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Cardiologie newQuery()
 * @method static \Illuminate\Database\Query\Builder|Cardiologie onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Cardiologie query()
 * @method static \Illuminate\Database\Eloquent\Builder|Cardiologie whereAlcool($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cardiologie whereAnamnese($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cardiologie whereArchievedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cardiologie whereAutres($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cardiologie whereConclusion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cardiologie whereConduiteATenir($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cardiologie whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cardiologie whereCreator($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cardiologie whereDateConsultation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cardiologie whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cardiologie whereDossierMedicalId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cardiologie whereEtablissementId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cardiologie whereExamenClinique($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cardiologie whereFacteurDeRisque($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cardiologie whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cardiologie whereNbreAnnee($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cardiologie whereNbreCigarette($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cardiologie whereNbreEnfant($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cardiologie wherePassedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cardiologie whereProfession($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cardiologie whereRendezVous($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cardiologie whereSituationFamiliale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cardiologie whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cardiologie whereTabac($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cardiologie whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Cardiologie withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Cardiologie withoutTrashed()
 * @mixin \Eloquent
 */
class Cardiologie extends Model
{
    use SoftDeletes;
    use Sluggable;

    protected $fillable = [
        "etablissement_id",
        "dossier_medical_id",
        "examen_clinique",
        "date_consultation",
        "anamnese",
        "facteur_de_risque",
        "profession",
        "situation_familiale",
        "nbre_enfant",
        "tabac",
        "alcool",
        "autres",
        "conclusion",
        "conduite_a_tenir",
        "rendez_vous",
        "slug",
        "nbreCigarette",
        "nbreAnnee",
        "creator",
        'archieved_at',
        'passed_at',
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

    public function operationables(){
        return $this->morphMany(Contributeurs::class,'operationable');
    }

    public function ligneDeTemps(){
        return $this->belongsTo(LigneDeTemps::class,'ligne_de_temps_id','id');
    }

    public function dossier(){
        return $this->belongsTo(DossierMedical::class,'dossier_medical_id','id');
    }

    public function etablissement(){
        return $this->belongsTo(EtablissementExercice::class,'etablissement_id','id');
    }

    public function parametresCommun(){
        return $this->morphMany(ParametreCommun::class,'communable');
    }

    public function actions(){
        return $this->morphMany(ActionMotif::class,'actionable');
    }

    public function files(){
        return $this->morphMany(File::class,'fileable');
    }

    public function examenCardios(){
        return $this->hasMany(ExamenCardio::class,'cardiologie_id','id');
    }

    public function author (){
        return $this->belongsTo(User::class,'creator','id');
    }

    public function updateConsultationCardiologique(){
        if(!is_null($this)){
            $user = $this->dossier->patient->user;
            $patient = $this->dossier->patient;
            $motifs = [];

            foreach ($this->actions as $action){
                array_push($motifs,$action->motifs);
            }

            foreach ($motifs as $motif)
            {
                $motifIsAuthor = checkIfIsAuthorOrIsAuthorized("Motif",$motif->id,"create");
                $motif['isAuthor'] = $motifIsAuthor->getOriginalContent();
            }

            $this['motifs']= $motifs;
            $this['user']=$user;
            $this['patient']=$patient;
            $isAuthor = checkIfIsAuthorOrIsAuthorized("Cardiologie",$this->id,"create");
            $canUpdate = checkIfCanUpdated("Cardiologie",$this->id,"create");
            $author = $this->author;
            if (!is_null($author)){
//                $this['author']['user'] = $author;
            }else {
                unset($this['author']);
                $this['author'] = getAuthor("Cardiologie", $this->id, "create");
            }
            $this['isAuthor']=$isAuthor->getOriginalContent();
            $connectedUser = Auth::user();
            if ($connectedUser->getRoleNames()->first() == 'Praticien'){
                $this['canUpdate']=$canUpdate->getOriginalContent() && is_null($this->passed_at) && is_null($this->archieved_at);
            }elseif ($connectedUser->getRoleNames()->first() == 'Medecin controle'){
                if ($isAuthor->getOriginalContent() == true)
                    $this['canUpdate'] = is_null($this->archieved_at);
                else{
                    $this['canUpdate']=$canUpdate->getOriginalContent() && !is_null($this->passed_at) && is_null($this->archieved_at);
                }
            }elseif($connectedUser->getRoleNames()->first() == 'Admin'){
                $this['canUpdate']=true;
            }
        }
    }

    public function rdv(){
        return $this->morphOne(RendezVous::class,'sourceable');
    }

    protected static function boot()
    {


        parent::boot();

        static::addGlobalScope(new RestrictArchievedAt);

    }
}
