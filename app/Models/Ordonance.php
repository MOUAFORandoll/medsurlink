<?php

namespace App\Models;

use App\User;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ordonance extends Model
{
    use SoftDeletes;
    use Sluggable;
    use SluggableScopeHelpers;

    protected $fillable = [
        "slug",
        "dossier_medical_id",
        "date_prescription",
        "praticien_id",
        "prescription_id",
        "archieved_at",
        "passed_at",
    ];
    protected $dates = [
        "date_prescription",
        "archieved_at",
        "passed_at",
    ];

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'DossierAndTimestamp'
            ]
        ];
    }

    public function getDossierAndTimestampAttribute() {
        return $this->dossier->slug.''.Carbon::now()->timestamp;
    }

    public function dossier(){
        return $this->belongsTo(DossierMedical::class,'dossier_medical_id','id');
    }

    public function medicaments(){
        return $this->belongsToMany(Medicament::class,'ordonance_medicament','ordonance_id','medicament_id');
    }

    public function updateOrdonance(){
        $isAuthor = checkIfIsAuthorOrIsAuthorized('Ordonance',$this->id,'create');
        $this['isAuthor']=$isAuthor->getOriginalContent();
    }

    public function praticien(){
        return $this->belongsTo(User::class,'praticien_id','id');
    }

}
