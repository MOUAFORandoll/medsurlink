<?php

namespace App\Models;

use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\DelaiOperation
 *
 * @property int $id
 * @property int|null $patient_id
 * @property int $delai_operationable_id
 * @property string $delai_operationable_type
 * @property string $date_heure_prevue
 * @property string $date_heure_effectif
 * @property string|null $observation
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read Model|\Eloquent $delai_operationable
 * @property-read mixed $patient_id_and_timestamp
 * @property-read \App\Models\Patient|null $patient
 * @property-read \App\Models\TypeOperation $type_observation
 * @method static \Illuminate\Database\Eloquent\Builder|DelaiOperation findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|DelaiOperation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DelaiOperation newQuery()
 * @method static \Illuminate\Database\Query\Builder|DelaiOperation onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|DelaiOperation query()
 * @method static \Illuminate\Database\Eloquent\Builder|DelaiOperation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DelaiOperation whereDateHeureEffectif($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DelaiOperation whereDateHeurePrevue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DelaiOperation whereDelaiOperationableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DelaiOperation whereDelaiOperationableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DelaiOperation whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DelaiOperation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DelaiOperation whereObservation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DelaiOperation wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DelaiOperation whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DelaiOperation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|DelaiOperation withTrashed()
 * @method static \Illuminate\Database\Query\Builder|DelaiOperation withoutTrashed()
 * @mixin \Eloquent
 */
class DelaiOperation extends Model
{
    use Sluggable;
    use SoftDeletes;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'delai_operations';

    protected $fillable = [
        "patient_id",
        "delai_operationable_id",
        "delai_operationable_type",
        "date_heure_prevue",
        "date_heure_effectif",
        "observation",
        "slug",
    ];


    public function getPatientIdAndTimestampAttribute() {
        return $this->patient_id.' '.Carbon::now()->timestamp;
    }

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'patientIdAndTimestamp'
            ]
        ];
    }

    public function patient(){
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    public function type_observation(){
        return $this->belongsTo(TypeOperation::class);
    }

    public function delai_operationable()
    {
        return $this->morphTo();
    }
}
