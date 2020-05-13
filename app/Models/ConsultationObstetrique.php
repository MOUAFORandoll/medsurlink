<?php

namespace App\Models;

use App\Models\Traits\SlugRoutable;
use App\Scopes\RestrictDossierScope;
use App\User;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Netpok\Database\Support\RestrictSoftDeletes;

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
