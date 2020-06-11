<?php

namespace App\Models;

use App\Models\Traits\SlugRoutable;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class ParametreCommun extends Model
{
    use SoftDeletes;
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
                'source' => 'ConsultationAndTimestamp'
            ]
        ];
    }
    public function getConsultationAndTimestampAttribute() {
        return str_random(6). ' ' .Carbon::now()->timestamp;
    }
    protected $fillable = [
        "consultation_medecine_generale_id",
        "poids",
        "taille",
        "bmi",
        "ta_systolique",
        "ta_diastolique",
        "temperature",
        "frequence_cardiaque",
        "frequence_respiratoire",
        "sato2",
        "perimetre_abdominal",
        'slug',
        'communable_type',
        'communable_id',
    ];

    public function consultation(){
        return $this->belongsTo(ConsultationMedecineGenerale::class,'consultation_medecine_generale_id','id');
    }

    public function updateParametreCommun(){
        if (!is_null($this)){
            $isAuthor = checkIfIsAuthorOrIsAuthorized("ParametreCommun",$this->id,"create");
            $canUpdate = checkIfCanUpdated("ParametreCommun",$this->id,"create");
            $connectedUser = Auth::user();
            if ($connectedUser->getRoleNames()->first() == 'Praticien'){
                $this['canUpdate']=$canUpdate->getOriginalContent();
            }elseif ($connectedUser->getRoleNames()->first() == 'Medecin controle'){
                if ($isAuthor->getOriginalContent() == true)
                    $this['canUpdate'] = true;
                else{
                    $this['canUpdate']=$canUpdate->getOriginalContent() ;
                }
            }elseif($connectedUser->getRoleNames()->first() == 'Admin'){
                $this['canUpdate']=true;
            }
            $this['isAuthor'] = $isAuthor->getOriginalContent();
            $consultation = !is_null($this->consultation) ? $this->consultation : $this->communable;
            $this['user'] = $consultation->dossier->patient->user;
            $this['dossier'] = $consultation->dossier;
            $this['consultation']  = $consultation;
//            $this['consultation']['dossier']  = $consultation->dossier;
        }
    }

    public function communable(){
        return $this->morphTo();
    }
}
