<?php

namespace App\Models;

use App\Models\Traits\SlugRoutable;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use http\Client\Curl\User;
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
        'archieved_at',
        'passed_at',
        'slug'
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
    public function scopeRestrictWithRole($query){
        $user = Auth::user();
        $userRoles = $user->getRoleNames();

        if(gettype($userRoles->search('Patient')) == 'integer'){
               $user = \App\User::with(['patient'])->whereId(Auth::id())->first();
               $dossier = $user->patient->dossier;
                 return $query->where('dossier_medical_id','=',$dossier->id);
        }elseif(gettype($userRoles->search('Souscripteur')) == 'integer'){
            $user = \App\User::with(['patient'])->whereId(Auth::id())->first();
            $patients = $user->souscripteur->patients;
            $dossiers = [];
            foreach ($patients as $patient){
                array_push($dossiers,$patient->dossier->id);
            }
           return $query->whereIn('dossier_medical_id',$dossiers);
        }
        else{
            return $query;
        }
    }
}
