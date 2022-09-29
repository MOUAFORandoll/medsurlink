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

/**
 * App\Models\CompteRenduOperatoire
 *
 * @property int $id
 * @property int $etablissement_id
 * @property int $dossier_medical_id
 * @property int|null $creator
 * @property string|null $type_intervention
 * @property string|null $histoire_clinique
 * @property string|null $date_intervention
 * @property string|null $chirugiens
 * @property string|null $aides
 * @property string|null $circulants
 * @property string|null $anesthesistes
 * @property string|null $type_anesthesie
 * @property string|null $description
 * @property string|null $traitement_post_operatoire
 * @property string|null $archieved_at
 * @property string|null $passed_at
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read User|null $createur
 * @property-read \App\Models\DossierMedical $dossier
 * @property-read \App\Models\EtablissementExercice $etablissement
 * @property-read mixed $dossier_and_timestamp
 * @method static \Illuminate\Database\Eloquent\Builder|CompteRenduOperatoire findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|CompteRenduOperatoire newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CompteRenduOperatoire newQuery()
 * @method static \Illuminate\Database\Query\Builder|CompteRenduOperatoire onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|CompteRenduOperatoire query()
 * @method static \Illuminate\Database\Eloquent\Builder|CompteRenduOperatoire whereAides($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompteRenduOperatoire whereAnesthesistes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompteRenduOperatoire whereArchievedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompteRenduOperatoire whereChirugiens($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompteRenduOperatoire whereCirculants($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompteRenduOperatoire whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompteRenduOperatoire whereCreator($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompteRenduOperatoire whereDateIntervention($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompteRenduOperatoire whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompteRenduOperatoire whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompteRenduOperatoire whereDossierMedicalId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompteRenduOperatoire whereEtablissementId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompteRenduOperatoire whereHistoireClinique($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompteRenduOperatoire whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompteRenduOperatoire wherePassedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompteRenduOperatoire whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompteRenduOperatoire whereTraitementPostOperatoire($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompteRenduOperatoire whereTypeAnesthesie($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompteRenduOperatoire whereTypeIntervention($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompteRenduOperatoire whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|CompteRenduOperatoire withTrashed()
 * @method static \Illuminate\Database\Query\Builder|CompteRenduOperatoire withoutTrashed()
 * @mixin \Eloquent
 */
class CompteRenduOperatoire extends Model
{
    use SoftDeletes;
    use Sluggable;

    protected $fillable = [
        "etablissement_id",
        "dossier_medical_id",
        'type_intervention',
        'histoire_clinique',
        'date_intervention',
        'chirugiens',
        'aides',
        'circulants',
        'anesthesistes',
        'type_anesthesie',
        'description',
        'traitement_post_operatoire',
        'archieved_at',
        'passed_at',
        'creator',
        'slug',
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

    public static function boot()
    {
        parent::boot(); // TODO: Change the autogenerated stub
        //On définit le créateur à la création du suivi
        CompteRenduOperatoire::creating(function ($compteRenduOperatoire){
            $compteRenduOperatoire->creator = Auth::id();
        });

        static::addGlobalScope(new RestrictDossierScope);
        static::addGlobalScope(new RestrictArchievedAt);
    }

    public function createur(){
        return $this->belongsTo(User::class,'creator','id');
    }

    public function dossier(){
        return $this->belongsTo(DossierMedical::class,'dossier_medical_id','id');
    }

    public function etablissement(){
        return $this->belongsTo(EtablissementExercice::class,'etablissement_id','id');
    }

    public function updateCompteRendu()
    {
        $this['isAuthor'] = Auth::id() == $this->creator;
        $connectedUser = Auth::user();
        if (Auth::id() == $this->creator){
            $this['canUpdate'] = true;
        } elseif ($connectedUser->getRoleNames()->first() == 'Praticien') {
            $this['canUpdate'] = Auth::id() == $this->creator;
        } elseif ($connectedUser->getRoleNames()->first() == 'Medecin controle') {
            $this['canUpdate'] = is_null($this->archieved_at);
        }
    }

    public function scopeCompteRenduSemaineMoisAnnee($query, $intervalle_debut, $intervalle_fin)
    {
        return $query->where(function ($query) use($intervalle_debut, $intervalle_fin) {
            $query->whereDate('created_at', '>=', $intervalle_debut)->whereDate('created_at', '<=', $intervalle_fin);
        })->orderBy('created_at', 'asc');
    }
}
