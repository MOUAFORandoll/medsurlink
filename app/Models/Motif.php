<?php

namespace App\Models;

use App\Models\Traits\SlugRoutable;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Motif
 *
 * @property int $id
 * @property string $reference
 * @property string $description
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $slug
 * @property-read Motif|null $actions
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Affiliation[] $affiliations
 * @property-read int|null $affiliations_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ConsultationMedecineGenerale[] $consultations
 * @property-read int|null $consultations_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ConsultationMedecineGenerale[] $consultationsMedecines
 * @property-read int|null $consultations_medecines_count
 * @property-read mixed $reference_and_timestamp
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Hospitalisation[] $hospitalisation
 * @property-read int|null $hospitalisation_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\LigneDeTemps[] $ligneDeTemps
 * @property-read int|null $ligne_de_temps_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\LigneDeTemps[] $nLigneDeTemps
 * @property-read int|null $n_ligne_de_temps_count
 * @method static \Illuminate\Database\Eloquent\Builder|Motif findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|Motif newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Motif newQuery()
 * @method static \Illuminate\Database\Query\Builder|Motif onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Motif query()
 * @method static \Illuminate\Database\Eloquent\Builder|Motif whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Motif whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Motif whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Motif whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Motif whereReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Motif whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Motif whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Motif withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Motif withoutTrashed()
 * @mixin \Eloquent
 */
class Motif extends Model
{
    use SoftDeletes;
    use Sluggable;
    use SluggableScopeHelpers;
    use SlugRoutable;
    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'ReferenceAndTimestamp'
            ]
        ];
    }
    public function getReferenceAndTimestampAttribute() {
        return $this->reference . ' ' .Carbon::now()->timestamp;
    }
    protected $fillable = [
        "reference",
        "description",
        'slug'
    ];

    public  function  consultations(){
        return $this->belongsToMany(ConsultationMedecineGenerale::class,'consultation_motif','motif_id','consultation_medecine_generale_id');
    }
    public  function  hospitalisation(){
        return $this->belongsToMany(Hospitalisation::class,'hospitalisation_motif','motif_id','hospitalisation_id');
    }
    public  function  ligneDeTemps(){
        return $this->hasMany(LigneDeTemps::class,'motif_consultation_id','id');
    }
    public function updateMotif(){
        if (!is_null($this)){
            $isAuthor = checkIfIsAuthorOrIsAuthorized("Motif",$this->id,"create");
            $this['isAuthor'] = $isAuthor->getOriginalContent();
        }
    }

    public function actions(){
        return $this->hasOne(Motif::class,'motif_id','id');
    }

    public function consultationsMedecines(){

        return $this->morphedByMany(ConsultationMedecineGenerale::class, 'motiffable' ,'consultation_motif','motif_id', 'consultation_medecine_generale_id');
    }

    public function nLigneDeTemps(){

        return $this->morphedByMany(LigneDeTemps::class, 'motiffable', 'motif_consultation_id', 'id');
    }

    public function affiliations(){

        return $this->morphedByMany(Affiliation::class, 'motiffable');
    }


}
