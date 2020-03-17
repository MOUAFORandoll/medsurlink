<?php

namespace App\Models;

use App\User;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

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
                $this['author']['user'] = $author;
            }else {
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
}
