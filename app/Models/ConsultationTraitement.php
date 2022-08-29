<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\ConsultationTraitement
 *
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationTraitement newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationTraitement newQuery()
 * @method static \Illuminate\Database\Query\Builder|ConsultationTraitement onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationTraitement query()
 * @method static \Illuminate\Database\Query\Builder|ConsultationTraitement withTrashed()
 * @method static \Illuminate\Database\Query\Builder|ConsultationTraitement withoutTrashed()
 * @mixin \Eloquent
 */
class ConsultationTraitement extends Model
{
    use SoftDeletes;

    protected $fillable = [
        "consultation_medecine_generale_id",
        "traitement_id",
        "date",
        "ligne_de_temps_id"
    ];
}
