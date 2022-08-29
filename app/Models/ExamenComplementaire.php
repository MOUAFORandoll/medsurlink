<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\ExamenComplementaire
 *
 * @property int $id
 * @property string $slug
 * @property string $fr_description
 * @property string $reference
 * @property int $prix
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ExamenEtablissementPrix[] $examenComplementairePrix
 * @property-read int|null $examen_complementaire_prix_count
 * @property-read mixed $dossier_and_timestamp
 * @method static \Illuminate\Database\Eloquent\Builder|ExamenComplementaire findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamenComplementaire newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ExamenComplementaire newQuery()
 * @method static \Illuminate\Database\Query\Builder|ExamenComplementaire onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ExamenComplementaire query()
 * @method static \Illuminate\Database\Eloquent\Builder|ExamenComplementaire whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamenComplementaire whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamenComplementaire whereFrDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamenComplementaire whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamenComplementaire wherePrix($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamenComplementaire whereReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamenComplementaire whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamenComplementaire whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|ExamenComplementaire withTrashed()
 * @method static \Illuminate\Database\Query\Builder|ExamenComplementaire withoutTrashed()
 * @mixin \Eloquent
 */
class ExamenComplementaire extends Model
{
    use Sluggable;
    use SoftDeletes;
    protected $table = 'examen_complementaire';
    protected $fillable = [
        "fr_description",
        "en_description",
        "reference",
        "slug",
        "prix",
    ];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'DossierAndTimestamp'
            ]
        ];
    }
    public function examenComplementairePrix(){
        return $this->hasMany(ExamenEtablissementPrix::class,'examen_complementaire_id','id');
    }
    public function getDossierAndTimestampAttribute() {
        return Str::random(10) . ' ' .Carbon::now()->timestamp;
    }
}
