<?php

namespace App\Models;

use App\User;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Models\ActivitesAma;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\ActiviteAmaPatient
 *
 * @property int $id
 * @property int|null $activite_ama_id
 * @property int $etablissement_id
 * @property string|null $commentaire
 * @property int|null $creator
 * @property int|null $patient_id
 * @property string|null $statut
 * @property string|null $date_cloture
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $affiliation_id
 * @property int|null $ligne_temps_id
 * @property-read ActivitesAma|null $activitesAma
 * @property-read \App\Models\Affiliation|null $affiliation
 * @property-read User|null $createur
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\DelaiOperation[] $delai_operations
 * @property-read int|null $delai_operations_count
 * @property-read \App\Models\EtablissementExercice $etablissement
 * @property-read mixed $dossier_and_timestamp
 * @property-read \App\Models\LigneDeTemps|null $ligne_temps
 * @property-read \App\Models\Motif $motif
 * @property-read \App\Models\Patient|null $patient
 * @property-read User $updatedBy
 * @method static \Illuminate\Database\Eloquent\Builder|ActiviteAmaPatient findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|ActiviteAmaPatient newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ActiviteAmaPatient newQuery()
 * @method static \Illuminate\Database\Query\Builder|ActiviteAmaPatient onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ActiviteAmaPatient query()
 * @method static \Illuminate\Database\Eloquent\Builder|ActiviteAmaPatient whereActiviteAmaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActiviteAmaPatient whereAffiliationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActiviteAmaPatient whereCommentaire($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActiviteAmaPatient whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActiviteAmaPatient whereCreator($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActiviteAmaPatient whereDateCloture($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActiviteAmaPatient whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActiviteAmaPatient whereEtablissementId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActiviteAmaPatient whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActiviteAmaPatient whereLigneTempsId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActiviteAmaPatient wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActiviteAmaPatient whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActiviteAmaPatient whereStatut($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActiviteAmaPatient whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|ActiviteAmaPatient withTrashed()
 * @method static \Illuminate\Database\Query\Builder|ActiviteAmaPatient withoutTrashed()
 * @mixin \Eloquent
 */
class ActiviteAmaPatient extends Model
{
    use Sluggable;
    use SoftDeletes;

    protected $table = 'activites_ama_patient';
    protected $fillable = [
        'activite_ama_id',
        'etablissement_id',
        'affiliation_id',
        'ligne_temps_id',
        'commentaire',
        'patient_id',
        'creator',
        'statut',
        'date_cloture',
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

    public static function boot()
    {
        parent::boot(); // TODO: Change the autogenerated stub

        ActiviteAmaPatient::creating(function ($activite){
            $activite->creator = Auth::id();
        });

    }

    public function getDossierAndTimestampAttribute() {
        return Str::random(10) . ' ' .Carbon::now()->timestamp;
    }

    public function activitesAma(){
        return $this->belongsTo(ActivitesAma::class,'activite_ama_id','id');
    }

    public function createur(){
        return $this->belongsTo(User::class,'creator','id');
    }
    public function updatedBy(){
        return $this->belongsTo(User::class,'updated_by','id');
    }
    public function patient(){
        return $this->belongsTo(Patient::class,'patient_id','user_id');
    }


    public function affiliation(){
        return $this->belongsTo(Affiliation::class);
    }

    public function ligne_temps(){
        return $this->belongsTo(LigneDeTemps::class);
    }

    public function motif(){
        return $this->belongsTo(Motif::class);
    }

    public function etablissement(){
        return $this->belongsTo(EtablissementExercice::class);
    }

    public function delai_operations()
    {
        return $this->morphMany(DelaiOperation::class, 'delai_operationable');
    }

}
