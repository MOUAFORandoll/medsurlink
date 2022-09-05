<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\EtablissementExercicePatient
 *
 * @property int $id
 * @property int $etablissement_id
 * @property int $patient_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|EtablissementExercicePatient newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EtablissementExercicePatient newQuery()
 * @method static \Illuminate\Database\Query\Builder|EtablissementExercicePatient onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|EtablissementExercicePatient query()
 * @method static \Illuminate\Database\Eloquent\Builder|EtablissementExercicePatient whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EtablissementExercicePatient whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EtablissementExercicePatient whereEtablissementId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EtablissementExercicePatient whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EtablissementExercicePatient wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EtablissementExercicePatient whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|EtablissementExercicePatient withTrashed()
 * @method static \Illuminate\Database\Query\Builder|EtablissementExercicePatient withoutTrashed()
 * @mixin \Eloquent
 */
class EtablissementExercicePatient extends Model
{
    use SoftDeletes;
    protected $table = 'etablissement_exercice_patient';
    protected $fillable = [
        "etablissement_id",
        "patient_id",
    ];
}
