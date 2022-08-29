<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\DossierAllergie
 *
 * @method static \Illuminate\Database\Eloquent\Builder|DossierAllergie newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DossierAllergie newQuery()
 * @method static \Illuminate\Database\Query\Builder|DossierAllergie onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|DossierAllergie query()
 * @method static \Illuminate\Database\Query\Builder|DossierAllergie withTrashed()
 * @method static \Illuminate\Database\Query\Builder|DossierAllergie withoutTrashed()
 * @mixin \Eloquent
 */
class DossierAllergie extends Model
{
    use SoftDeletes;

    protected $fillable = [
        "dossier_medical_id",
        "allergie_id",
    ];
}
