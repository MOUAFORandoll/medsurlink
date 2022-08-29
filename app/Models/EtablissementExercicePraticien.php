<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\EtablissementExercicePraticien
 *
 * @property int $id
 * @property int $etablissement_id
 * @property int $praticien_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|EtablissementExercicePraticien newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EtablissementExercicePraticien newQuery()
 * @method static \Illuminate\Database\Query\Builder|EtablissementExercicePraticien onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|EtablissementExercicePraticien query()
 * @method static \Illuminate\Database\Eloquent\Builder|EtablissementExercicePraticien whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EtablissementExercicePraticien whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EtablissementExercicePraticien whereEtablissementId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EtablissementExercicePraticien whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EtablissementExercicePraticien wherePraticienId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EtablissementExercicePraticien whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|EtablissementExercicePraticien withTrashed()
 * @method static \Illuminate\Database\Query\Builder|EtablissementExercicePraticien withoutTrashed()
 * @mixin \Eloquent
 */
class EtablissementExercicePraticien extends Model
{
    use SoftDeletes;
    protected $table = "etablissement_exercice_praticien";

    protected $fillable = [
      "etablissement_id",
      "praticien_id",
    ];
}
