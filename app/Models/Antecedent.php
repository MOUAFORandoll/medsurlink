<?php

namespace App\Models;

use App\Models\Traits\SlugRoutable;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Antecedent extends Model
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
                'source' => 'TypeAndTimestamp'
            ]
        ];
    }
    public function getTypeAndTimestampAttribute() {
        return $this->type . ' ' .Carbon::now()->timestamp;
    }
    protected $fillable = [
        "dossier_medical_id",
        "description",
        "date",
        "type",
        'slug'
    ];

    public function dossier(){
        return $this->belongsTo(DossierMedical::class,'dossier_medical_id','id');
    }

    public function updateAntecedentItem(){
        if(!is_null($this)) {
            $isAuthor = checkIfIsAuthorOrIsAuthorized("Antecedent", $this->id, "create");
            $this['user'] = $this->dossier->patient->user;
            $this['isAuthor'] = $isAuthor->getOriginalContent();
            $connectedUser = Auth::user();
            if ($connectedUser->getRoleNames()->first() == 'Medecin controle') {
                $this['isAuthor'] = true;
            }
        }
    }

}
