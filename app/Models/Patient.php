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
        return $this->hasMany(ActiviteAmaPatient::class,'patient_id','id');
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
        return $this->hasMany(RendezVous::class, 'patient_id','id');
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

            }else if(gettype($userRoles->search('Souscripteur')) == 'integer'){
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

}
