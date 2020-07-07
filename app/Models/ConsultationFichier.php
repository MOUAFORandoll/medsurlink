<?php

namespace App\Models;

use App\User;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ConsultationFichier extends Model
{
    use SoftDeletes;
    use Sluggable;

    protected $fillable = [
        "name",
        "dossier_medical_id",
        "etablissement_id",
        "user_id",
        "slug",
        "creator",
        "passed_at",
        "archieved_at",
    ];

    protected $hidden = ['creator','created_at','updated_at','deleted_at'];

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'DossierAndTimestamp'
            ]
        ];
    }

    public function getDossierAndTimestampAttribute() {
        return Str::random(6) . ' ' .Carbon::now()->timestamp;
    }

    public static function boot()
    {
        parent::boot(); // TODO: Change the autogenerated stub
        ConsultationFichier::creating(function ($consultation){
            $consultation->creator = Auth::id();
        });
    }

    public function dossier(){
        return $this->belongsTo(DossierMedical::class,'dossier_medical_id','id');
    }

    public function etablissement(){
        return $this->belongsTo(EtablissementExercice::class,'etablissement_id','id');
    }

    public function files(){
        return $this->morphMany(File::class,'fileable');
    }

    public function praticien(){
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function updateConsultation(){
        if(!is_null($this)){
           $this['isAuthor'] = ($this->creator == Auth::id() );
        }
    }
}
