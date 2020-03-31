<?php

namespace App\Models;

use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Medicament extends Model
{
    use SoftDeletes;
    use Sluggable;
    use SluggableScopeHelpers;

    protected $fillable = [
        "nom_commercial",
        "principe_actif",
        "classe_medicamenteuse",
        "forme_et_dosage",
        "conditionement",
        "nom_specialite",
        "nom_dci",
        "slug",
    ];

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'medoc'
            ]
        ];
    }

    public function getMedocAttribute() {
        return $this->nom_commercial.''.Carbon::now()->timestamp;
    }

    public function ordonances(){
        return $this->belongsToMany(Ordonance::class,'ordonance_medicament','medicament_id','ordonance_id');
    }

    public function updateMedicament(){
        $isAuthor = checkIfIsAuthorOrIsAuthorized('Medicament',$this->id,'create');
        $this['isAuthor']=$isAuthor->getOriginalContent();
    }
}
