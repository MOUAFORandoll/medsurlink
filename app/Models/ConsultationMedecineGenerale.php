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
    protected $restrictDeletes = ['motifs','traitements','allergies','antecedents','conclusions'];

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
        'traitement_propose'
    ];

    public function dossier(){
        return $this->belongsTo(DossierMedical::class,'dossier_medical_id','id');
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
        $user = $this->dossier->patient->user;
        $patient = $this->dossier->patient;
        $allergies = $this->dossier->allergies;

        foreach ($allergies as $allergy)
        {
            $allergieIsAuthor = checkIfIsAuthorOrIsAuthorized("Allergie",$allergy->id,"create");
            $allergy['isAuthor'] = $allergieIsAuthor->getOriginalContent();
        }
        $this['allergies']= $allergies;
        $this['user']=$user;
        $this['patient']=$patient;
        $isAuthor = checkIfIsAuthorOrIsAuthorized("ConsultationMedecineGenerale",$this->id,"create");
        $this['isAuthor']=$isAuthor->getOriginalContent();
    }

}
