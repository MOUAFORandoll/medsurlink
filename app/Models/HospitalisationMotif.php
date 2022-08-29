<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\HospitalisationMotif
 *
 * @method static \Illuminate\Database\Eloquent\Builder|HospitalisationMotif newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HospitalisationMotif newQuery()
 * @method static \Illuminate\Database\Query\Builder|HospitalisationMotif onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|HospitalisationMotif query()
 * @method static \Illuminate\Database\Query\Builder|HospitalisationMotif withTrashed()
 * @method static \Illuminate\Database\Query\Builder|HospitalisationMotif withoutTrashed()
 * @mixin \Eloquent
 */
class HospitalisationMotif extends Model
{
    use SoftDeletes;

    protected $fillable = [
        "hospitalisation_id",
        "motif_id",
    ];
}
