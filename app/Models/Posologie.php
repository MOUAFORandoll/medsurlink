<?php

namespace App\Models;

use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

/**
 * App\Models\Posologie
 *
 * @property int $id
 * @property int $prescription_id
 * @property float $dose
 * @property string $formulation
 * @property string $voieAdmin
 * @property int $nombre
 * @property string $par
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $name_and_timestamp
 * @property-read \App\Models\Prescription $prescription
 * @method static \Illuminate\Database\Eloquent\Builder|Posologie findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|Posologie newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Posologie newQuery()
 * @method static \Illuminate\Database\Query\Builder|Posologie onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Posologie query()
 * @method static \Illuminate\Database\Eloquent\Builder|Posologie whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Posologie whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Posologie whereDose($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Posologie whereFormulation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Posologie whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Posologie whereNombre($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Posologie wherePar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Posologie wherePrescriptionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Posologie whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Posologie whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Posologie whereVoieAdmin($value)
 * @method static \Illuminate\Database\Query\Builder|Posologie withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Posologie withoutTrashed()
 * @mixin \Eloquent
 */
class Posologie extends Model
{
    use SoftDeletes;
    use Sluggable;

    protected $fillable = [
        "prescription_id",
        "dose",
        "formulation",
        "voieAdmin",
        "nombre",
        "par",
        "slug",
    ];

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'NameAndTimestamp'
            ]
        ];
    }

    public function getNameAndTimestampAttribute() {
        return Str::random(10).' '.Carbon::now()->timestamp;
    }

    public function prescription(){
        return $this->belongsTo(Prescription::class,'prescription_id','id');
    }
}
