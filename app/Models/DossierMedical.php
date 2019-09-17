<?php

namespace App\Models;

use App\Models\Traits\SlugRoutable;
use App\Scopes\RestrictPatientScope;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Netpok\Database\Support\RestrictSoftDeletes;

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

    public function consultationsObstetrique(){
        return $this->hasMany(ConsultationObstetrique::class,'dossier_medical_id','id');
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

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

            static::addGlobalScope(new RestrictPatientScope);
    }
}
