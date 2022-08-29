<?php

namespace App\Models;

use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

/**
 * App\Models\Prescription
 *
 * @property int $id
 * @property int $medicament_id
 * @property int $ordonance_id
 * @property string|null $info_comp
 * @property string $date_fin
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $name_and_timestamp
 * @property-read \App\Models\Medicament $medicament
 * @property-read \App\Models\Ordonance $ordonnance
 * @property-read \App\Models\Posologie|null $posology
 * @method static \Illuminate\Database\Eloquent\Builder|Prescription findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|Prescription newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Prescription newQuery()
 * @method static \Illuminate\Database\Query\Builder|Prescription onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Prescription query()
 * @method static \Illuminate\Database\Eloquent\Builder|Prescription whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Prescription whereDateFin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Prescription whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Prescription whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Prescription whereInfoComp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Prescription whereMedicamentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Prescription whereOrdonanceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Prescription whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Prescription whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Prescription withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Prescription withoutTrashed()
 * @mixin \Eloquent
 */
class Prescription extends Model
{
    use SoftDeletes;
    use Sluggable;

    protected $fillable = [
        "ordonance_id",
        "medicament_id",
        "info_comp",
        "date_fin",
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

    public function medicament(){
        return $this->belongsTo(Medicament::class,'medicament_id','id');
    }

    public function posology(){
        return $this->hasOne(Posologie::class,'prescription_id','id');
    }

    public function ordonnance(){
        return $this->belongsTo(Ordonance::class,'ordonance_id','id');
    }

}
