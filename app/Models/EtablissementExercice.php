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

/**
 * App\Models\EtablissementExercice
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string $slug
 * @property string|null $logo
 * @property string|null $adresse
 * @property-read \Illuminate\Database\Eloquent\Collection|Assistante[] $assistantes
 * @property-read int|null $assistantes_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Comptable[] $comptables
 * @property-read int|null $comptables_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\FactureAvis[] $factureAvis
 * @property-read int|null $facture_avis_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Facture[] $factures
 * @property-read int|null $factures_count
 * @property-read mixed $name_and_timestamp
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\MedecinControle[] $medecinControles
 * @property-read int|null $medecin_controles_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Patient[] $patients
 * @property-read int|null $patients_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Praticien[] $praticiens
 * @property-read int|null $praticiens_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\EtablissementPrestation[] $prestations
 * @property-read int|null $prestations_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\RendezVous[] $rendezVous
 * @property-read int|null $rendez_vous_count
 * @method static \Illuminate\Database\Eloquent\Builder|EtablissementExercice findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|EtablissementExercice newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EtablissementExercice newQuery()
 * @method static \Illuminate\Database\Query\Builder|EtablissementExercice onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|EtablissementExercice query()
 * @method static \Illuminate\Database\Eloquent\Builder|EtablissementExercice whereAdresse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EtablissementExercice whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EtablissementExercice whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EtablissementExercice whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EtablissementExercice whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EtablissementExercice whereLogo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EtablissementExercice whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EtablissementExercice whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EtablissementExercice whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|EtablissementExercice withTrashed()
 * @method static \Illuminate\Database\Query\Builder|EtablissementExercice withoutTrashed()
 * @mixin \Eloquent
 */
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

        // static::addGlobalScope(new RestrictEtablissementScope);
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

    public function rendezVous(){
        return $this->hasMany(RendezVous::class, 'etablissement_id');
    }
}
