<?php

namespace App\Models;

use App\Models\Traits\SlugRoutable;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TraitementActuel extends Model
{
    use SoftDeletes;
    use Sluggable;
    use SluggableScopeHelpers;
    use SlugRoutable;

    protected $fillable = [
        "dossier_medical_id",
        "description",
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
                'source' => 'DescriptionAndTimestamp'
            ]
        ];
    }

    public function getDescriptionAndTimestampAttribute()
    {
        return substr($this->description,0,4) . ' ' . Carbon::now()->timestamp;
    }

    public function dossier()
    {
        return $this->belongsTo(DossierMedical::class,'dossier_medical_id');
    }

    public function updateTraitementActuel(){
        if(!is_null($this)){
            $traitementIsAuthor = checkIfIsAuthorOrIsAuthorized("TraitementActuel",$this->id,"create");
            $this['isAuthor'] = $traitementIsAuthor->getOriginalContent();
        }
    }
}
