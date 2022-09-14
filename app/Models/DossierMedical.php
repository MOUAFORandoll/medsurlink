<?php

namespace App\Models;

use App\Models\Traits\SlugRoutable;
use App\Scopes\RestrictPatientScope;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Netpok\Database\Support\RestrictSoftDeletes;

/**
 * App\Models\DossierMedical
 *
 * @property int $id
 * @property int $patient_id
 * @property string $date_de_creation
 * @property string $numero_dossier
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string $slug
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Allergie[] $allergies
 * @property-read int|null $allergies_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Antecedent[] $antecedents
 * @property-read int|null $antecedents_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Avis[] $avis
 * @property-read int|null $avis_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Cardiologie[] $cardiologies
 * @property-read int|null $cardiologies_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\CompteRenduOperatoire[] $comptesRenduOperatoire
 * @property-read int|null $comptes_rendu_operatoire_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ConsultationFichier[] $consultationsManuscrites
 * @property-read int|null $consultations_manuscrites_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ConsultationMedecineGenerale[] $consultationsMedecine
 * @property-read int|null $consultations_medecine_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ConsultationObstetrique[] $consultationsObstetrique
 * @property-read int|null $consultations_obstetrique_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\PatientSouscripteur[] $financeurs
 * @property-read int|null $financeurs_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Hospitalisation[] $hospitalisations
 * @property-read int|null $hospitalisations_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Kinesitherapie[] $kinesitherapies
 * @property-read int|null $kinesitherapies_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Ordonance[] $ordonances
 * @property-read int|null $ordonances_count
 * @property-read \App\Models\Package $package
 * @property-read \App\Models\Patient $patient
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ResultatImagerie[] $resultatsImagerie
 * @property-read int|null $resultats_imagerie_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ResultatLabo[] $resultatsLabo
 * @property-read int|null $resultats_labo_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\TraitementActuel[] $traitements
 * @property-read int|null $traitements_count
 * @method static \Illuminate\Database\Eloquent\Builder|DossierMedical findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|DossierMedical newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DossierMedical newQuery()
 * @method static \Illuminate\Database\Query\Builder|DossierMedical onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|DossierMedical query()
 * @method static \Illuminate\Database\Eloquent\Builder|DossierMedical whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DossierMedical whereDateDeCreation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DossierMedical whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DossierMedical whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DossierMedical whereNumeroDossier($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DossierMedical wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DossierMedical whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DossierMedical whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|DossierMedical withTrashed()
 * @method static \Illuminate\Database\Query\Builder|DossierMedical withoutTrashed()
 */
class DossierMedical extends Model
{
    use SoftDeletes;
    use Sluggable;
    use SluggableScopeHelpers;
    use SlugRoutable;
    use RestrictSoftDeletes;

    protected $fillable = [
        "patient_id",
        "date_de_creation",
        "numero_dossier",
        'slug'
    ];

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => ['patient.slug','numero_dossier']
            ]
        ];
    }
    /**
     * The relations restricting model deletion
     */
    protected $restrictDeletes = ['consultationsObstetrique','consultationsMedecine'];

    public function patient(){
        return $this->belongsTo(Patient::class,'patient_id','user_id');
    }

    public function affiliations(){
        return $this->hasMany(Affiliation::class,'patient_id','user_id');
    }

    public function resultatsImagerie(){
        return $this->hasMany(ResultatImagerie::class,'dossier_medical_id','id');
    }

    public function resultatsLabo(){
        return $this->hasMany(ResultatLabo::class,'dossier_medical_id','id');
    }

    public function hospitalisations(){
        return $this->hasMany(Hospitalisation::class,'dossier_medical_id','id');
    }

    public function consultationsObstetrique(){
        return $this->hasMany(ConsultationObstetrique::class,'dossier_medical_id','id');
    }

    public function consultationsManuscrites(){
        return $this->hasMany(ConsultationFichier::class,'dossier_medical_id','id');
    }

    public function consultationsMedecine(){
        return $this->hasMany(ConsultationMedecineGenerale::class,'dossier_medical_id','id');
    }

    public function allergies(){
        return $this->belongsToMany(Allergie::class,'dossier_allergie','dossier_medical_id','allergie_id');
    }

    public function antecedents(){
        return $this->hasMany(Antecedent::class,'dossier_medical_id','id');
    }

    public function traitements()
    {
        return $this->hasMany(TraitementActuel::class, 'dossier_medical_id');
    }

    public function ordonances()
    {
        return $this->hasMany(Ordonance::class, 'dossier_medical_id');
    }

    public function cardiologies()
    {
        return $this->hasMany(Cardiologie::class, 'dossier_medical_id');
    }

    public function comptesRenduOperatoire(){
        return $this->hasMany(CompteRenduOperatoire::class,'dossier_medical_id','id');
    }

    public function kinesitherapies(){
        return $this->hasMany(Kinesitherapie::class,'dossier_medical_id','id');
    }
    public function avis(){
        return $this->hasMany(Avis::class,'dossier_medical_id','id');
    }
    public function financeurs()
    {
        return $this->hasMany(PatientSouscripteur::class, 'patient_id','user_id');
    }
    public function package(){
        return $this->belongsTo(Package::class,'package_id','id');
    }
    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        // static::addGlobalScope(new RestrictPatientScope);
    }

    public function updateDossier(){
        if(!is_null($this)){
            foreach ($this->traitements as $traitement){
                $traitementIsAuthor = checkIfIsAuthorOrIsAuthorized("TraitementActuel",$traitement->id,"create");
                $traitement['isAuthor'] = $traitementIsAuthor->getOriginalContent();
            }

            foreach ($this->allergies as $allergy){
                $allergyAuthor = checkIfIsAuthorOrIsAuthorized("Allergie",$allergy->id,"create");
                $allergy['isAuthor'] = $allergyAuthor->getOriginalContent();
            }

            foreach ($this->antecedents as $antecedent){
                $antecedentAuthor = checkIfIsAuthorOrIsAuthorized("Antecedent",$antecedent->id,"create");
                $antecedent['isAuthor'] = $antecedentAuthor->getOriginalContent();
            }

            foreach ($this->consultationsObstetrique as $consultation){
                $author = $consultation->author;
                if (!is_null($author)){

                }else {
                    unset($consultation['author']);
                    $consultation['author'] = getAuthor("ConsultationObstetrique", $consultation->id, "create");
                }
                $consultation['etablissement'] = $consultation->etablissement;
            }

            foreach ($this->consultationsMedecine as $consultation){
                $author = $consultation->author;
                if (!is_null($author)){

                }else {
                    unset($consultation['author']);
                    $consultation['author'] = getAuthor("ConsultationMedecineGenerale", $consultation->id, "create");
                }
                $consultation['motifs'] = $consultation->motifs;
                $consultation['conclusions'] = $consultation->conclusions;
                $consultation['etablissement'] = $consultation->etablissement;
            }

            foreach ($this->cardiologies as $consultation){
                $motifs = [];
                $author = $consultation->author;
                if (!is_null($author)){

                }else {
                    unset($consultation['author']);
                    $consultation['author'] = getAuthor("Cardiologie", $consultation->id, "create");
                }
                foreach ($consultation->actions as $action){
                    array_push($motifs,$action->motifs);
                }

                $consultation['motifs'] = $motifs;
                $consultation['etablissement'] = $consultation->etablissement;
            }

            foreach ($this->hospitalisations as $hospitalisation){
                $author = $hospitalisation->author;
                if (!is_null($author)){

                }else {
                    unset($hospitalisation['author']);
                    $hospitalisation['author'] = getAuthor("Hospitalisation", $hospitalisation->id, "create");
                }
                $hospitalisation['motifs'] = $hospitalisation->motifs;
            }
        }
    }
}
