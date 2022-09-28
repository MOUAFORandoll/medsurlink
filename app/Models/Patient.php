<?php

namespace App\Models;

use App\Models\Traits\SlugRoutable;
use App\User;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\UnauthorizedException;
use Netpok\Database\Support\RestrictSoftDeletes;

/**
 * App\Models\Patient
 *
 * @property string $slug
 * @property int|null $user_id
 * @property int|null $souscripteur_id
 * @property string $date_de_naissance
 * @property string $sexe
 * @property int|null $age
 * @property int|null $consentement
 * @property int|null $restriction
 * @property string|null $nom_contact
 * @property string|null $tel_contact
 * @property string|null $lien_contact
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ActiviteAmaPatient[] $activitesAma
 * @property-read int|null $activites_ama_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Affiliation[] $affiliations
 * @property-read int|null $affiliations_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Auteur[] $auteurs
 * @property-read int|null $auteurs_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\DelaiOperation[] $delai_operations
 * @property-read int|null $delai_operations_count
 * @property-read \App\Models\DossierMedical|null $dossier
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\EtablissementExercice[] $etablissements
 * @property-read int|null $etablissements_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\PatientSouscripteur[] $financeurs
 * @property-read int|null $financeurs_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\PatientMedecinControle[] $medecinReferent
 * @property-read int|null $medecin_referent_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Payment[] $payments
 * @property-read int|null $payments_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\RendezVous[] $rendezVous
 * @property-read int|null $rendez_vous_count
 * @property-read \App\Models\Souscripteur|null $souscripteur
 * @property-read User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|Patient findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|Patient newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Patient newQuery()
 * @method static \Illuminate\Database\Query\Builder|Patient onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Patient query()
 * @method static \Illuminate\Database\Eloquent\Builder|Patient restrictUser()
 * @method static \Illuminate\Database\Eloquent\Builder|Patient whereAge($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patient whereConsentement($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patient whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patient whereDateDeNaissance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patient whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patient whereLienContact($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patient whereNomContact($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patient whereRestriction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patient whereSexe($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patient whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patient whereSouscripteurId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patient whereTelContact($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patient whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patient whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|Patient withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Patient withoutTrashed()
 * @mixin \Eloquent
 */
class Patient extends Model
{
    use SoftDeletes;
    use RestrictSoftDeletes;
    use Sluggable;
    use SluggableScopeHelpers;
    use SlugRoutable;
    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'user_id';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The relations restricting model deletion
     */
    protected $restrictDeletes = ['dossier'];
    protected $fillable = [
        "user_id",
        "souscripteur_id",
        "sexe",
        "date_de_naissance",
        "age",
        "nom_contact",
        "tel_contact",
        "lien_contact",
        'consentement',
        'restriction',
        'slug',
    ];
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'user.slug'
            ]
        ];
    }

    public function souscripteur(){
        return $this->belongsTo(Souscripteur::class,'souscripteur_id','user_id');
    }

    public function affiliations(){
        return $this->hasMany(Affiliation::class,'patient_id','user_id');
    }
    public function dossier(){
        return $this->hasOne(DossierMedical::class,'patient_id','user_id');
    }
    public function activitesAma(){
        return $this->hasMany(ActiviteAmaPatient::class,'patient_id','user_id');
    }
    public function activitesMedecinReferent(){
        return $this->hasMany(ActivitesControle::class,'patient_id','user_id');
    }
    public function auteurs()
    {
        return $this->morphMany(Auteur::class, 'auteurable');
    }

    public function financeurs()
    {
        return $this->hasMany(PatientSouscripteur::class, 'patient_id','user_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'patient_id','user_id');
    }

    public function rendezVous()
    {
        return $this->hasMany(RendezVous::class, 'patient_id','user_id');
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function medecinReferent(){
        return $this->hasMany(PatientMedecinControle::class,'patient_id','user_id');
    }

    public function etablissements(){
        return $this->belongsToMany(EtablissementExercice::class,'etablissement_exercice_patient','patient_id','etablissement_id');
    }

    public function scopeRestrictUser($builder){

        if (Auth::check()){
            $user = Auth::user();
            $userRoles = $user->getRoleNames();
            if(gettype($userRoles->search('Patient')) == 'integer'){
                $user = \App\User::with(['patient'])->whereId(Auth::id())->first();
                $builder->where('user_id',$user->id);

            }else if(gettype($userRoles->search('Assistante')) == 'integer'){
                return $builder;
                 } else if(gettype($userRoles->search('Souscripteur')) == 'integer'){
                $user = \App\User::with(['patient'])->whereId(Auth::id())->first();
                //Récupération des patiens du souscripteur
                $patients = $user->souscripteur->patients;
                $patientsId = [];
                foreach ($patients as $patient){
                    array_push($patientsId,$patient->user_id);
                }

                $patientSouscripteurs = PatientSouscripteur::where('financable_id',Auth::id())->get();

                foreach ($patientSouscripteurs as  $patient){
                    if (!in_array($patient->patient_id,$patientsId)){
                        array_push($patientsId,$patient->patient_id);
                    }
                }

                $builder->whereIn('user_id',$patientsId);
            }
            else{
                return $builder;
            }
        }else{

            throw new UnauthorizedException("Veuillez vous authentifier",401);
        }
    }

    public function ajouterSouscripteur($souscripteur_id):void{
        $financeur = PatientSouscripteur::create([
            'financable_type'=>'Souscripteur',
            'financable_id'=>$souscripteur_id,
            'patient_id'=>$this->user_id
        ]);
    }

    public function delai_operations(){
        return $this->hasMany(DelaiOperation::class, 'patient_id','user_id');
    }

    public function scopePatientSemaineMoisAnnee($query, $intervalle_debut, $intervalle_fin)
    {
        return $query->where(function ($query) use($intervalle_debut, $intervalle_fin) {
            $query->whereDate('created_at', '>=', $intervalle_debut)->whereDate('created_at', '<=', $intervalle_fin);
        })->orderBy('created_at', 'asc');
    }

}
