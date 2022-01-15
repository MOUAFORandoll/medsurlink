<?php

namespace App\Models;

use App\User;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class RendezVous extends Model
{
    use SoftDeletes;
    use Sluggable;
    use SluggableScopeHelpers;

    protected $table='rendez_vous';

    protected $fillable = [
        "sourceable_id",
        "sourceable_type",
        "patient_id",
        "praticien_id",
        "initiateur",
        "motifs",
        "date",
        "statut",
        "slug",
        "nom_medecin"
    ];

    protected $hidden = ['initiateur','updated_at'];
    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'NameAndTimestamp'
            ]
        ];
    }

    public function getNameAndTimestampAttribute() {
        return Str::random(16).' '.Carbon::now()->timestamp;
    }

    public function patient(){
        return $this->belongsTo(User::class,'patient_id','id');
    }

    public function praticien(){
        return $this->belongsTo(User::class,'praticien_id','id');
    }

    public function initiateur(){
        return $this->belongsTo(User::class,'initiateur','id');
    }


    public function sourceable(){
        return $this->morphTo();
    }

    public function updateRendezVous(){
        if(!is_null($this)){
            $rdv = $this;
            $user =  $rdv->patient;
            $patient = $user->patient;
            if (!is_null($patient)){
                $dossier = $patient->dossier;
                unset($this->patient['patient']);
                $this->patient['dossier_medical'] =$dossier;
            }
        }
    }
}
