<?php

namespace App\Models;

use App\Models\Traits\SlugRoutable;
use App\Scopes\RestrictDossierScope;
use App\Scopes\RestrictHospitalisationScope;
use App\User;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Hospitalisation extends Model
{
    use SoftDeletes;
    protected $fillable = [
        "dossier_medical_id",
        "date_entree",
        "date_sortie",
        "histoire_clinique",
        "mode_de_vie",
        "evolution",
        "conclusion",
        "avis",
        "traitement_sortie",
        "rendez_vous",
        'slug',
        "examen_clinique",
        "examen_complementaire",
        "traitement_propose",
        'archieved_at',
        'passed_at',
        'etablissement_id',
        'creator',
    ];
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
                'source' =>'DossierAndTimestamp'
            ]
        ];
    }
    public function getDossierAndTimestampAttribute() {
        return $this->dossier->slug . ' ' .Carbon::now()->timestamp;
    }
    public function dossier(){
        return $this->belongsTo(DossierMedical::class,'dossier_medical_id','id');
    }

    public function examensClinique(){
        return $this->belongsToMany(ExamenClinique::class,'hospitalisation_exam_clin','hospitalisation_id','examen_clinique_id');
    }

    public function examensComplementaire(){
        return $this->belongsToMany(ExamenComplementaire::class,'hospitalisation_exam_com','hospitalisation_id','examen_complementaire_id');
    }

    public  function  motifs(){
        return $this->belongsToMany(Motif::class,'hospitalisation_motif','hospitalisation_id','motif_id');
    }

    public function etablissement(){
        return $this->belongsTo(EtablissementExercice::class,'etablissement_id','id');
    }

    public function author (){
        return $this->belongsTo(User::class,'creator','id');
    }

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new RestrictHospitalisationScope);
    }

    public function updateHospitalisation(){
        if (!is_null($this)){
            $user = $this->dossier->patient->user;
            $patient = $this->dossier->patient;
            $this['user']=$user;
            $this['patient']=$patient;
            $author = $this->author;
            if (!is_null($author)){
//                $this['author']['user'] = $author;
            }else{
                unset($this['author']);
                $this['author'] = getAuthor("Hospitalisation",$this->id,"create");
            }
            $isAuthor = checkIfIsAuthorOrIsAuthorized("Hospitalisation",$this->id,"create");
            $this['isAuthor']=$isAuthor->getOriginalContent();

            $connectedUser = Auth::user();
            if ($connectedUser->getRoleNames()->first() == 'Medecin controle') {
                $this['isAuthor'] = true;
            }
        }
    }

    public function rdv(){
        return $this->morphOne(RendezVous::class,'sourceable');
    }
}
