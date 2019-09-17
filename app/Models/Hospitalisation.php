<?php

namespace App\Models;

use App\Models\Traits\SlugRoutable;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
}
