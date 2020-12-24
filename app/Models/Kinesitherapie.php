<?php

namespace App\Models;

use App\Scopes\RestrictArchievedAt;
use App\Scopes\RestrictDossierScope;
use App\User;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class Kinesitherapie extends Model
{
    use Sluggable;
    use SoftDeletes;

    protected $fillable = [
      "etablissement_id",
      "creator",
      "dossier_medical_id",
      "date_consultation",
      "motifs",
      "anamnese",
      "profession",
      "evaluation_globale",
      "impression_diagnostique",
      "examens_complementaires",
      "conduite_a_tenir",
      "slug",
      "archieved_at",
      "passed_at",
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
                'source' => 'DossierAndTimestamp'
            ]
        ];
    }
    public function getDossierAndTimestampAttribute() {
        return Str::random(10) . ' ' .Carbon::now()->timestamp;
    }

    public function dossier(){
        return $this->belongsTo(DossierMedical::class,'dossier_medical_id','id');
    }

    public function etablissement(){
        return $this->belongsTo(EtablissementExercice::class,'etablissement_id','id');
    }

    public function author (){
        return $this->belongsTo(User::class,'creator','id');
    }

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new RestrictDossierScope);
        static::addGlobalScope(new RestrictArchievedAt);

        Kinesitherapie::creating(function ($consultation){
            $consultation->creator = Auth::id();
        });
    }

    public function operationables(){
        return $this->morphMany(Contributeurs::class,'operationable');
    }

    public function files(){
        return $this->morphMany(File::class,'fileable');
    }


    public function rdv(){
        return $this->morphOne(RendezVous::class,'sourceable');
    }

    public function scopeOrderByDateConsultation($query)
    {
        return $query->orderBy('date_consultation', 'desc');
    }

    public function updateConsultation(){
        $this['isAuthor']=$this->creator == Auth::id();
        $connectedUser = Auth::user();
        if ($connectedUser->getRoleNames()->first() == 'Praticien'){
            $this['canUpdate']=$this['isAuthor'] && is_null($this->passed_at) && is_null($this->archieved_at);
        }elseif ($connectedUser->getRoleNames()->first() == 'Medecin controle'){
            $this['isAuthor'] == true;
            if ($this['isAuthor'] == true)
                $this['canUpdate'] = is_null($this->archieved_at);
            else{
                $this['canUpdate']= !is_null($this->passed_at) && is_null($this->archieved_at);
            }
        }elseif($connectedUser->getRoleNames()->first() == 'Admin'){
            $this['canUpdate']=true;
        }
    }
}
