<?php

namespace App\Models;

use App\Models\Traits\SlugRoutable;
use App\Scopes\RestrictArchievedAt;
use App\Scopes\RestrictDossierScope;
use App\User;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Netpok\Database\Support\RestrictSoftDeletes;

/**
 * App\Models\ConsultationMedecineGenerale
 *
 * @property int $id
 * @property int $dossier_medical_id
 * @property string|null $date_consultation
 * @property string|null $anamese
 * @property string|null $mode_de_vie
 * @property string|null $examen_clinique
 * @property string|null $examen_complementaire
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $slug
 * @property string|null $archieved_at
 * @property string|null $passed_at
 * @property string|null $traitement_propose
 * @property string|null $profession
 * @property string|null $situation_familiale
 * @property string $nbre_enfant
 * @property string $tabac
 * @property string $alcool
 * @property string|null $autres
 * @property int|null $etablissement_id
 * @property string|null $file
 * @property string $nbreAnnee
 * @property string $nbreCigarette
 * @property int|null $creator
 * @property string|null $information
 * @property array $examens
 * @property array $diasgnostic
 * @property array $nutrition
 * @property array $lipide
 * @property array $glucide
 * @property array $anamneses
 * @property string|null $anthropometrie
 * @property \Illuminate\Database\Eloquent\Collection|\App\Models\TraitementPropose[] $traitements
 * @property string|null $complementaire
 * @property int|null $ligne_de_temps_id
 * @property-read User|null $author
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Conclusion[] $conclusions
 * @property-read int|null $conclusions_count
 * @property-read \App\Models\DossierMedical $dossier
 * @property-read \App\Models\EtablissementExercice|null $etablissement
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\File[] $files
 * @property-read int|null $files_count
 * @property-read mixed $dossier_and_timestamp
 * @property-read \App\Models\LigneDeTemps|null $ligneDeTemps
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Motif[] $motifs
 * @property-read int|null $motifs_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Motif[] $n_motifs
 * @property-read int|null $n_motifs_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Contributeurs[] $operationables
 * @property-read int|null $operationables_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ParametreCommun[] $parametresCommun
 * @property-read int|null $parametres_commun_count
 * @property-read \App\Models\RendezVous|null $rdv
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\RendezVous[] $rendez_vous
 * @property-read int|null $rendez_vous_count
 * @property-read int|null $traitements_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ConsultationExamenValidation[] $validations
 * @property-read int|null $validations_count
 * @property-read \App\Models\VersionValidation|null $versionValidation
 * @method static Builder|ConsultationMedecineGenerale findSimilarSlugs($attribute, $config, $slug)
 * @method static Builder|ConsultationMedecineGenerale newModelQuery()
 * @method static Builder|ConsultationMedecineGenerale newQuery()
 * @method static \Illuminate\Database\Query\Builder|ConsultationMedecineGenerale onlyTrashed()
 * @method static Builder|ConsultationMedecineGenerale orderByDateConsultation()
 * @method static Builder|ConsultationMedecineGenerale passed()
 * @method static Builder|ConsultationMedecineGenerale query()
 * @method static Builder|ConsultationMedecineGenerale whereAlcool($value)
 * @method static Builder|ConsultationMedecineGenerale whereAnamese($value)
 * @method static Builder|ConsultationMedecineGenerale whereAnamneses($value)
 * @method static Builder|ConsultationMedecineGenerale whereAnthropometrie($value)
 * @method static Builder|ConsultationMedecineGenerale whereArchievedAt($value)
 * @method static Builder|ConsultationMedecineGenerale whereAutres($value)
 * @method static Builder|ConsultationMedecineGenerale whereComplementaire($value)
 * @method static Builder|ConsultationMedecineGenerale whereCreatedAt($value)
 * @method static Builder|ConsultationMedecineGenerale whereCreator($value)
 * @method static Builder|ConsultationMedecineGenerale whereDateConsultation($value)
 * @method static Builder|ConsultationMedecineGenerale whereDeletedAt($value)
 * @method static Builder|ConsultationMedecineGenerale whereDiasgnostic($value)
 * @method static Builder|ConsultationMedecineGenerale whereDossierMedicalId($value)
 * @method static Builder|ConsultationMedecineGenerale whereEtablissementId($value)
 * @method static Builder|ConsultationMedecineGenerale whereExamenClinique($value)
 * @method static Builder|ConsultationMedecineGenerale whereExamenComplementaire($value)
 * @method static Builder|ConsultationMedecineGenerale whereExamens($value)
 * @method static Builder|ConsultationMedecineGenerale whereFile($value)
 * @method static Builder|ConsultationMedecineGenerale whereGlucide($value)
 * @method static Builder|ConsultationMedecineGenerale whereId($value)
 * @method static Builder|ConsultationMedecineGenerale whereInformation($value)
 * @method static Builder|ConsultationMedecineGenerale whereLigneDeTempsId($value)
 * @method static Builder|ConsultationMedecineGenerale whereLipide($value)
 * @method static Builder|ConsultationMedecineGenerale whereModeDeVie($value)
 * @method static Builder|ConsultationMedecineGenerale whereNbreAnnee($value)
 * @method static Builder|ConsultationMedecineGenerale whereNbreCigarette($value)
 * @method static Builder|ConsultationMedecineGenerale whereNbreEnfant($value)
 * @method static Builder|ConsultationMedecineGenerale whereNutrition($value)
 * @method static Builder|ConsultationMedecineGenerale wherePassedAt($value)
 * @method static Builder|ConsultationMedecineGenerale whereProfession($value)
 * @method static Builder|ConsultationMedecineGenerale whereSituationFamiliale($value)
 * @method static Builder|ConsultationMedecineGenerale whereSlug($value)
 * @method static Builder|ConsultationMedecineGenerale whereTabac($value)
 * @method static Builder|ConsultationMedecineGenerale whereTraitementPropose($value)
 * @method static Builder|ConsultationMedecineGenerale whereTraitements($value)
 * @method static Builder|ConsultationMedecineGenerale whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|ConsultationMedecineGenerale withTrashed()
 * @method static \Illuminate\Database\Query\Builder|ConsultationMedecineGenerale withoutTrashed()
 * @mixin \Eloquent
 */
class ConsultationMedecineGenerale extends Model
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
                'source' => 'DossierAndTimestamp'
            ]
        ];
    }
    public function getDossierAndTimestampAttribute() {
        return $this->dossier->slug . ' ' .Carbon::now()->timestamp;
    }
    /**
     * The relations restricting model deletion
     */

      /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'consultation_medecine_generales';

    protected $restrictDeletes = [];

    protected $casts = [
        'diasgnostic' => 'array',
        'nutrition' => 'array',
        'lipide' => 'array',
        'glucide' => 'array',
        'examens' => 'array',
        'anamneses' => 'array',
    ];

    protected $fillable = [
        "dossier_medical_id",
        "date_consultation",
        "anamese",
        "mode_de_vie",
        'archieved_at',
        'passed_at',
        'slug',
        "examen_clinique",
        "examen_complementaire",
        "complementaire",
        'traitement_propose',
        "profession",
        "situation_familiale",
        "nbre_enfant",
        "tabac",
        "alcool",
        "autres",
        "etablissement_id",
        "file",
        "nbreCigarette",
        "nbreAnnee",
        "creator",
        "diasgnostic",
        "nutrition",
        "lipide",
        "glucide",
        "examens",
        "anamneses",
        "anthropometrie",
        "information",
        "ligne_de_temps_id",
    ];

    public function dossier(){
        return $this->belongsTo(DossierMedical::class,'dossier_medical_id','id');
    }

    public function etablissement(){
        return $this->belongsTo(EtablissementExercice::class,'etablissement_id','id');
    }

    public  function  motifs(){
        return $this->belongsToMany(Motif::class,'consultation_motif','consultation_medecine_generale_id','motif_id');
    }

    public function traitements(){
        return $this->hasMany(TraitementPropose::class,'consultation_medecine_generale_id');
    }

    public function conclusions(){
        return $this->hasMany(Conclusion::class,'consultation_medecine_generale_id','id');
    }

    public function versionValidation(){
        return $this->hasOne(VersionValidation::class,'consultation_general_id','id');
    }
    public function parametresCommun(){
        return $this->hasMany(ParametreCommun::class,'consultation_medecine_generale_id','id');
    }

    public function author (){
        return $this->belongsTo(User::class,'creator','id');
    }

    public function ligneDeTemps(){
        return $this->belongsTo(LigneDeTemps::class,'ligne_de_temps_id','id');
    }
    public function  validations(){
        return $this->hasMany(ConsultationExamenValidation::class,'consultation_general_id','id');
    }
    public function rendez_vous(){
        return $this->hasMany(RendezVous::class);
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

    public function scopePassed($query){

    }

    public function updateConsultationMedecine(){
        if(!is_null($this)){
            $user = isset($this->dossier) ? $this->dossier->patient->user : null;
            $patient = isset($this->dossier) ? $this->dossier->patient : null;
            $motifs = $this->motifs;

            foreach ($motifs as $motif)
            {
                $motifIsAuthor = checkIfIsAuthorOrIsAuthorized("Motif",$motif->id,"create");
                $motif['isAuthor'] = $motifIsAuthor->getOriginalContent();
            }

            $this['motifs']= $motifs;
            $this['user']=$user;
            $this['patient']=$patient;
            $isAuthor = checkIfIsAuthorOrIsAuthorized("ConsultationMedecineGenerale",$this->id,"create");
            $canUpdate = checkIfCanUpdated("ConsultationMedecineGenerale",$this->id,"create");
            $author = $this->author;
            if (!is_null($author)){
//                $this['author'] = $author;
            }else{
                unset($this['author']);
                $this['author'] = getAuthor("ConsultationMedecineGenerale",$this->id,"create");
            }
            $this['isAuthor']=$isAuthor->getOriginalContent();
            $connectedUser = Auth::user();
            if ($connectedUser->getRoleNames()->first() == 'Praticien'){
                $this['canUpdate']=$canUpdate->getOriginalContent() && is_null($this->passed_at) && is_null($this->archieved_at);
            }elseif ($connectedUser->getRoleNames()->first() == 'Medecin controle'){
                $this['isAuthor']=true;
                if ($isAuthor->getOriginalContent() == true){
                    $this['canUpdate'] = is_null($this->archieved_at);
                }
                else{
                    $this['canUpdate']=$canUpdate->getOriginalContent() && !is_null($this->passed_at) && is_null($this->archieved_at);
                }
            }elseif($connectedUser->getRoleNames()->first() == 'Admin'){
                $this['canUpdate']=true;
            }
        }
    }

    public function scopeOrderByDateConsultation($query)
    {
        return $query->orderBy('date_consultation', 'desc');
    }

    public function operationables(){
        return $this->morphMany(Contributeurs::class,'operationable');
    }

    public function files(){
        return $this->morphMany(File::class,'fileable');
    }


    public function rdv(){
        return $this->morphOne(RendezVous::class,'sourceable');
    }

    public function n_motifs(){
        return $this->morphToMany(Motif::class, 'motiffable', 'consultation_medecine_generale_id','motif_id');
    }

  /*
   public function setDiasgnosticAttribute($value)
    {
        $diasgnostic = [];



        $this->attributes['diasgnostic'] = json_encode($diasgnostic);
    }
   public function setNutritionAttribute($value)
    {
        $nutrition = [];

        foreach ($value as $array_item) {
            if (!is_null($array_item['key'])) {
                $nutrition[] = $array_item;
            }
        }

        $this->attributes['nutrition'] = json_encode($nutrition);
    }
    public function setLipideAttribute($value)
    {
        $lipide = [];

        foreach ($value as $array_item) {
            if (!is_null($array_item['key'])) {
                $lipide[] = $array_item;
            }
        }

        $this->attributes['lipide'] = json_encode($lipide);
    }
    public function setGlucideAttribute($value)
    {
        $glucide = [];
       $value = json_decode($value);
        foreach ($value as $array_item) {
            if (!is_null($array_item['key'])) {
                $glucide[] = $array_item;
            }
        }

        $this->attributes['glucide'] = json_encode($glucide);
    }
    public function setExamensAttribute($value)
    {
        $examens = [];

        foreach ($value as $array_item) {
            if (!is_null($array_item['key'])) {
                $examens[] = $array_item;
            }
        }

        $this->attributes['examens'] = json_encode($examens);
    }*/
}
