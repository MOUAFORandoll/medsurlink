<?php

namespace App\Models;

use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\PatientSouscripteur
 *
 * @property int $id
 * @property string $slug
 * @property string $financable_type
 * @property int $financable_id
 * @property int $patient_id
 * @property int|null $lien_de_parente
 * @property int $souscripteur_consentement
 * @property int $patient_consentement
 * @property int|null $restriction
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Model|\Eloquent $financable
 * @property-read mixed $consultation_and_timestamp
 * @property-read \App\Models\Dictionnaire|null $lien
 * @property-read \App\Models\Patient $patients
 * @method static \Illuminate\Database\Eloquent\Builder|PatientSouscripteur findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|PatientSouscripteur newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PatientSouscripteur newQuery()
 * @method static \Illuminate\Database\Query\Builder|PatientSouscripteur onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|PatientSouscripteur query()
 * @method static \Illuminate\Database\Eloquent\Builder|PatientSouscripteur whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PatientSouscripteur whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PatientSouscripteur whereFinancableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PatientSouscripteur whereFinancableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PatientSouscripteur whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PatientSouscripteur whereLienDeParente($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PatientSouscripteur wherePatientConsentement($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PatientSouscripteur wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PatientSouscripteur whereRestriction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PatientSouscripteur whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PatientSouscripteur whereSouscripteurConsentement($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PatientSouscripteur whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|PatientSouscripteur withTrashed()
 * @method static \Illuminate\Database\Query\Builder|PatientSouscripteur withoutTrashed()
 * @mixin \Eloquent
 */
class PatientSouscripteur extends Model
{
    use SoftDeletes;
    use Sluggable;

    protected $fillable = [
        "financable_type",
        "financable_id",
        "patient_id",
        "lien_de_parente",
        "slug",
        'souscripteur_consentement',
        'patient_consentement',
        'restriction'
    ];

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'ConsultationAndTimestamp'
            ]
        ];
    }
    public function getConsultationAndTimestampAttribute() {
        return str_random(6). ' ' .Carbon::now()->timestamp;
    }

    public function financable(){
        return $this->morphTo();
    }

    public function patients(){
        return $this->belongsTo(Patient::class,'patient_id','user_id');
    }

    public function lien(){
        return $this->belongsTo(Dictionnaire::class,'lien_de_parente','id');
    }
}
