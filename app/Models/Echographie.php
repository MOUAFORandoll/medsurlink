<?php

namespace App\Models;

use App\Models\Traits\SlugRoutable;
use App\Scopes\RestrictConsultationObstetriqueScope;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Echographie extends Model
{
    use SoftDeletes;

    protected $fillable = [
        "consultation_obstetrique_id",
        "date_creation",
        "type",
        "ddr",
        "dpa",
        "semaine_amenorrhee",
        "biometrie",
        "annexe",
        "description",
        'slug',
        "ligne_de_temps_id"
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
                'source' => 'TypeAndTimestamp'
            ]
        ];
    }
    public function getTypeAndTimestampAttribute() {
        return $this->type . ' ' .Carbon::now()->timestamp;
    }
    public function consultation(){
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

    public function updateEchographie(){
        if (!is_null($this)){
            $isAuthor = checkIfIsAuthorOrIsAuthorized("Echographie",$this->id,"create");
            $this['isAuthor'] = $isAuthor->getOriginalContent();
        }
    }
}
