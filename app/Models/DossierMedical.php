<?php

namespace App\Models;

use App\Models\Traits\SlugRoutable;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DossierMedical extends Model
{
    use SoftDeletes;
    use Sluggable;
    use SluggableScopeHelpers;
    use SlugRoutable;

    protected $fillable = [
      "patient_id",
      "date_de_creation",
      "numero_dossier",
      'slug'
    ];

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => ['patient.slug','numero_dossier']
            ]
        ];
    }

    public function patient(){
        return $this->belongsTo(Patient::class,'patient_id','user_id');
    }
}
