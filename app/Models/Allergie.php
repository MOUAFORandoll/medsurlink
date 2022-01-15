<?php

namespace App\Models;

use App\Models\Traits\SlugRoutable;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use function GuzzleHttp\Psr7\str;

class Allergie extends Model
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
                'source' => 'DescriptionAndTimestamp'
            ]
        ];
    }
    public function getDescriptionAndTimestampAttribute() {
        return substr($this->description,0,5). ' ' .Carbon::now()->timestamp;
    }

    protected $fillable = [
        "description",
        "date",
        'slug'
    ];


    public  function  dossiers(){
        return $this->belongsToMany(DossierMedical::class,'dossier_allergie','allergie_id','dossier_medical_id');
    }

    public function updateAllergyItem(){
        if(!is_null($this)) {
            $connectedUser = Auth::user();
            if ($connectedUser->getRoleNames()->first() == 'Medecin controle' || $connectedUser->getRoleNames()->first() == 'Praticien') {
                $this['isAuthor'] = true;
            }
            $this['dossier'] = $this->dossiers->first();
            if (!is_null($this->dossiers->first())) {
                $this['patient'] = $this->dossiers->first()->patient;
                $this['user'] = $this->dossiers->first()->patient->user;
            }
        }
    }
}
