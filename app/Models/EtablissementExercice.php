<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\Assistante;
use App\Models\Traits\SlugRoutable;
use Illuminate\Database\Eloquent\Model;
use App\Scopes\RestrictEtablissementScope;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Netpok\Database\Support\RestrictSoftDeletes;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;

class EtablissementExercice extends Model
{
    use SoftDeletes;
    use RestrictSoftDeletes;
    use Sluggable;
    use SluggableScopeHelpers;
    use SlugRoutable;
    /**
     * The relations restricting model deletion
     */
    protected $restrictDeletes = ['praticiens'];

    protected $fillable = [
        "name",
        "description",
        'slug',
        'logo',
        'adresse'

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
                'source' => 'NameAndTimestamp'
            ]
        ];
    }
    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new RestrictEtablissementScope);
    }
    public function getNameAndTimestampAttribute() {
        return $this->name. ' ' .Carbon::now()->timestamp;
    }

    public function praticiens(){
        return $this->belongsToMany(Praticien::class,'etablissement_exercice_praticien','etablissement_id','praticien_id');
    }
    public function medecinControles(){
        return $this->belongsToMany(MedecinControle::class,'etablissement_exercice_medecin','etablissement_id','medecin_controle_id');
    }

    public function patients(){
        return $this->belongsToMany(Patient::class,'etablissement_exercice_patient','etablissement_id','patient_id');
    }

    public function prestations(){
        return $this->hasMany(EtablissementPrestation::class,'etablissement_id','id');
    }

    public function factures(){
        return $this->hasMany(Facture::class,'etablissement_id','id');
    }

    public function factureAvis(){
        return $this->hasMany(FactureAvis::class,'etablissement_id','id');
    }

    public function comptables(){
        return $this->hasMany(Comptable::class,'etablissement_id','id');
    }
    public function assistantes(){
        return $this->hasMany(Assistante::class,'etablissement_id','id');
    }
}
