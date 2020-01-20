<?php

namespace App\Models;

use App\Models\Traits\SlugRoutable;
use App\Scopes\RestrictDossierScope;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Netpok\Database\Support\RestrictSoftDeletes;

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
    protected $restrictDeletes = [];

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
        'traitement_propose',
        "profession",
        "situation_familiale",
        "nbre_enfant",
        "tabac",
        "alcool",
        "autres",
        "etablissement_id",
        "file"
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

    public function parametresCommun(){
        return $this->hasMany(ParametreCommun::class,'consultation_medecine_generale_id','id');
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
    }

    public function updateConsultationMedecine(){
        if(!is_null($this)){
            $user = $this->dossier->patient->user;
            $patient = $this->dossier->patient;
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

    public function scopeOrderByDateConsultation($query)
    {
        return $query->orderBy('date_consultation', 'desc');
    }
}
