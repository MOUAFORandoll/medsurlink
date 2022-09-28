<?php

namespace App\Models;

use App\Models\Traits\SlugRoutable;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\TraitementActuel
 *
 * @property int $id
 * @property int $dossier_medical_id
 * @property string $slug
 * @property string $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\DossierMedical $dossier
 * @property-read mixed $description_and_timestamp
 * @method static \Illuminate\Database\Eloquent\Builder|TraitementActuel findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|TraitementActuel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TraitementActuel newQuery()
 * @method static \Illuminate\Database\Query\Builder|TraitementActuel onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|TraitementActuel query()
 * @method static \Illuminate\Database\Eloquent\Builder|TraitementActuel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TraitementActuel whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TraitementActuel whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TraitementActuel whereDossierMedicalId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TraitementActuel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TraitementActuel whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TraitementActuel whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|TraitementActuel withTrashed()
 * @method static \Illuminate\Database\Query\Builder|TraitementActuel withoutTrashed()
 * @mixin \Eloquent
 */
class TraitementActuel extends Model
{
    use SoftDeletes;
    use Sluggable;
    use SluggableScopeHelpers;
    use SlugRoutable;

    protected $fillable = [
        "dossier_medical_id",
        "description",
        'slug'
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
                'source' => 'DescriptionAndTimestamp'
            ]
        ];
    }

    public function getDescriptionAndTimestampAttribute()
    {
        return substr($this->description,0,4) . ' ' . Carbon::now()->timestamp;
    }

    public function dossier()
    {
        return $this->belongsTo(DossierMedical::class,'dossier_medical_id');
    }

    public function updateTraitementActuel(){
        if(!is_null($this)){
            $traitementIsAuthor = checkIfIsAuthorOrIsAuthorized("TraitementActuel",$this->id,"create");
            $this['isAuthor'] = $traitementIsAuthor->getOriginalContent();
        }
    }

    public function scopeTraitementSemaineMoisAnnee($query, $intervalle_debut, $intervalle_fin)
    {
        return $query->where(function ($query) use($intervalle_debut, $intervalle_fin) {
            $query->whereDate('created_at', '>=', $intervalle_debut)->whereDate('created_at', '<=', $intervalle_fin);
        })->orderBy('created_at', 'asc');
    }
}
