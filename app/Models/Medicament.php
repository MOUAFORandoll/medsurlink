<?php

namespace App\Models;

use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Medicament
 *
 * @property int $id
 * @property string|null $nom_commercial
 * @property string|null $principe_actif
 * @property string|null $classe_medicamenteuse
 * @property string|null $forme_et_dosage
 * @property string|null $conditionement
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $nom_specialite
 * @property string $nom_dci
 * @property-read mixed $medoc
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Ordonance[] $ordonances
 * @property-read int|null $ordonances_count
 * @property-read \App\Models\Prescription|null $prescription
 * @method static \Illuminate\Database\Eloquent\Builder|Medicament findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|Medicament newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Medicament newQuery()
 * @method static \Illuminate\Database\Query\Builder|Medicament onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Medicament query()
 * @method static \Illuminate\Database\Eloquent\Builder|Medicament whereClasseMedicamenteuse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Medicament whereConditionement($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Medicament whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Medicament whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Medicament whereFormeEtDosage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Medicament whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Medicament whereNomCommercial($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Medicament whereNomDci($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Medicament whereNomSpecialite($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Medicament wherePrincipeActif($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Medicament whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Medicament whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Medicament withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Medicament withoutTrashed()
 * @mixin \Eloquent
 */
class Medicament extends Model
{
    use SoftDeletes;
    use Sluggable;
    use SluggableScopeHelpers;

    protected $fillable = [
        "nom_commercial",
        "principe_actif",
        "classe_medicamenteuse",
        "forme_et_dosage",
        "conditionement",
        "nom_specialite",
        "nom_dci",
        "slug",
    ];

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'medoc'
            ]
        ];
    }

    public function getMedocAttribute() {
        return $this->nom_commercial.''.Carbon::now()->timestamp;
    }

    public function ordonances(){
        return $this->belongsToMany(Ordonance::class,'ordonance_medicament','medicament_id','ordonance_id');
    }

    public function updateMedicament(){
        $isAuthor = checkIfIsAuthorOrIsAuthorized('Medicament',$this->id,'create');
        $this['isAuthor']=$isAuthor->getOriginalContent();
    }

    public function prescription(){
        return $this->hasOne(Prescription::class,'id');
    }
}
