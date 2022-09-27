<?php

namespace App\Models;

use App\Models\Traits\SlugRoutable;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Antonrom\ModelChangesHistory\Traits\HasChangesHistory;
/**
 * App\Models\Affiliation
 *
 * @property int $id
 * @property int $patient_id
 * @property string $nom
 * @property string $date_debut
 * @property string|null $date_fin
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $slug
 * @property int|null $souscripteur_id
 * @property int|null $package_id
 * @property int|null $paiement_id
 * @property string|null $date_signature
 * @property string $status_contrat
 * @property string $status_paiement
 * @property int $renouvelle
 * @property int $expire
 * @property string $code_contrat
 * @property int $niveau_urgence
 * @property int $nombre_envois_email
 * @property int $expire_email
 * @property string|null $plainte
 * @property string|null $contact_firstName
 * @property string|null $contact_name
 * @property string|null $contact_phone
 * @property string|null $paye_par_affilie
 * @property int $selected
 * @property-read \App\Models\Cloture|null $cloture
 * @property-read mixed $nom_and_timestamp
 * @property-read \Illuminate\Database\Eloquent\Collection|\Antonrom\ModelChangesHistory\Models\Change[] $historyChangesMorph
 * @property-read int|null $history_changes_morph_count
 * @property-read \Antonrom\ModelChangesHistory\Models\Change|null $latestChangeMorph
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\LigneDeTemps[] $ligneTemps
 * @property-read int|null $ligne_temps_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Motif[] $motifs
 * @property-read int|null $motifs_count
 * @property-read \App\Models\Package|null $package
 * @property-read \App\Models\Patient $patient
 * @property-read \App\Models\Souscripteur|null $souscripteur
 * @method static \Illuminate\Database\Eloquent\Builder|Affiliation findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|Affiliation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Affiliation newQuery()
 * @method static \Illuminate\Database\Query\Builder|Affiliation onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Affiliation query()
 * @method static \Illuminate\Database\Eloquent\Builder|Affiliation whereCodeContrat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Affiliation whereContactFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Affiliation whereContactName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Affiliation whereContactPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Affiliation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Affiliation whereDateDebut($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Affiliation whereDateFin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Affiliation whereDateSignature($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Affiliation whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Affiliation whereExpire($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Affiliation whereExpireEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Affiliation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Affiliation whereNiveauUrgence($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Affiliation whereNom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Affiliation whereNombreEnvoisEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Affiliation wherePackageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Affiliation wherePaiementId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Affiliation wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Affiliation wherePayeParAffilie($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Affiliation wherePlainte($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Affiliation whereRenouvelle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Affiliation whereSelected($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Affiliation whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Affiliation whereSouscripteurId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Affiliation whereStatusContrat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Affiliation whereStatusPaiement($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Affiliation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Affiliation withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Affiliation withoutTrashed()
 * @mixin \Eloquent
 */
class Affiliation extends Model
{
    use SoftDeletes;
    use Sluggable;
    use SluggableScopeHelpers;
    use SlugRoutable;
    use HasChangesHistory;

    protected $fillable = [
        "patient_id",
        "souscripteur_id",
        "package_id",
        "paiement_id",
        "date_signature",
        "status_contrat",
        "status_paiement",
        "renouvelle",
        "expire",
        "code_contrat",
        "niveau_urgence",
        'plainte',
        'paye_par_affilie',
        'contact_firstName',
        'contact_name',
        'contact_phone',
        "nombre_envois_email",
        "expire_email",
        "nom",
        "date_debut",
        "date_fin",
        "selected", // par quelle canal avez vous entendu parler de medicasure pour la première fois ?
        'slug'
    ];

    protected $attributes = [
        'status_contrat' => 'Généré',
        'status_paiement' => "NON PAYE",
        'renouvelle' => 0,
        'expire' => 0
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
                'source' => 'NomAndTimestamp'
            ]
        ];
    }
    public function getNomAndTimestampAttribute() {
        return $this->nom . ' ' .Carbon::now()->timestamp;
    }

    public function patient(){
        return $this->belongsTo(Patient::class,'patient_id','user_id');
    }

    public function souscripteur(){
        return $this->belongsTo(Souscripteur::class,'souscripteur_id','user_id');
    }

    public function package(){
        return $this->belongsTo(Package::class,'package_id','id');
    }

    public function ligneTemps(){
        return $this->hasMany(LigneDeTemps::class)->orderBy('updated_at', 'desc');
    }

    public function motifs(){
        return $this->morphToMany(Motif::class, 'motiffable');
    }

    public function cloture(){
        return $this->morphOne(Cloture::class, 'cloturable');
    }

    /**
     * Scope a query to only include the last n days records
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWhereDateBetween($query, $fieldName, $fromDate, $todate)
    {
        return $query->where($fieldName, '>=', $fromDate)->where($fieldName, '<=', $todate);
    }
}
