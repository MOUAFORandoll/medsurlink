<?php

namespace App\Models;

use App\Models\Traits\SlugRoutable;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Motif extends Model
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
                'source' => 'ReferenceAndTimestamp'
            ]
        ];
    }
    public function getReferenceAndTimestampAttribute() {
        return $this->reference . ' ' .Carbon::now()->timestamp;
    }
    protected $fillable = [
        "reference",
        "description",
        'slug'
    ];

    public  function  consultations(){
        return $this->belongsToMany(ConsultationMedecineGenerale::class,'consultation_motif','motif_id','consultation_medecine_generale_id');
    }
    public  function  hospitalisation(){
        return $this->belongsToMany(Hospitalisation::class,'hospitalisation_motif','motif_id','hospitalisation_id');
    }
    public  function  ligneDeTemps(){
        return $this->hasMany(LigneDeTemps::class,'motif_consultation_id','id');
    }
    public function updateMotif(){
        if (!is_null($this)){
            $isAuthor = checkIfIsAuthorOrIsAuthorized("Motif",$this->id,"create");
            $this['isAuthor'] = $isAuthor->getOriginalContent();
        }
    }

    public function actions(){
        return $this->hasOne(Motif::class,'motif_id','id');
    }
}
