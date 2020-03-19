<?php

namespace App\Models;

use App\Models\Traits\SlugRoutable;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Netpok\Database\Support\RestrictSoftDeletes;
use App\Scopes\RestrictConsultationObstetriqueScope;

class ConsultationPrenatale extends Model
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
                'source' => 'TypeDeConsultationAndTimestamp'
            ]
        ];
    }
    public function getTypeDeConsultationAndTimestampAttribute() {
        return $this->type_de_consultation . ' ' .Carbon::now()->timestamp;
    }
    /**
     * The relations restricting model deletion
     */
    protected $restrictDeletes = [''];

    protected $fillable = [
        "consultation_obstetrique_id",
        "type_de_consultation",
        "plaintes",
        "recommandations",
        'archieved_at',
        'passed_at',
        'slug',
        "examen_clinique",
        "examen_complementaire",
    ];

    public function parametresObstetrique(){
        return $this->hasMany(ParametreObstetrique::class,'consultation_prenatale_id','id');
    }

    public function consultationObstetrique(){
        return $this->belongsTo(ConsultationObstetrique::class,'consultation_obstetrique_id','id');
    }
    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new RestrictConsultationObstetriqueScope);
    }

    public function updatePrenatalConsultation(){
        if (!is_null($this)){
            $dossier = $this->consultationObstetrique->dossier;
            $user = $dossier->patient->user;
            $this['user']=$user;
            $this['dossier']=$dossier;
            $isAuthor = checkIfIsAuthorOrIsAuthorized("ConsultationPrenatale",$this->id,"create");
            $this['author'] = getAuthor("ConsultationPrenatale",$this->id,"create");
            $this['isAuthor']=$isAuthor->getOriginalContent();
        }
    }
}
