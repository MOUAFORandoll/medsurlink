<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\EtablissementExerciceMedecin
 *
 * @property int $id
 * @property int $etablissement_id
 * @property int $medecin_controle_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|EtablissementExerciceMedecin newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EtablissementExerciceMedecin newQuery()
 * @method static \Illuminate\Database\Query\Builder|EtablissementExerciceMedecin onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|EtablissementExerciceMedecin query()
 * @method static \Illuminate\Database\Eloquent\Builder|EtablissementExerciceMedecin whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EtablissementExerciceMedecin whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EtablissementExerciceMedecin whereEtablissementId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EtablissementExerciceMedecin whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EtablissementExerciceMedecin whereMedecinControleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EtablissementExerciceMedecin whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|EtablissementExerciceMedecin withTrashed()
 * @method static \Illuminate\Database\Query\Builder|EtablissementExerciceMedecin withoutTrashed()
 * @mixin \Eloquent
 */
class EtablissementExerciceMedecin extends Model
{
    use SoftDeletes;
    protected $table = "etablissement_exercice_medecin";

    protected $fillable = [
        "etablissement_id",
        "medecin_controle_id",
        ];
}
