<?php

namespace App\Models;

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
        "dossier_medical_id"
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
                'source' => 'dossier'
            ]
        ];
    }

    public function getDossierAttribute() {
        return $this->dossier()->slug.''.Carbon::now()->timestamp;
    }

    public function dossier(){
        return $this->belongsTo(DossierMedical::class,'dossier_medical_id','id');
    }

    public function medicaments(){
        return $this->hasMany(OrdonanceMedicament::class,'ordonance_id','id');
    }
}
