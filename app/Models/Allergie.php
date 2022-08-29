<?php

namespace App\Models;

use App\Models\Traits\SlugRoutable;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use function GuzzleHttp\Psr7\str;

/**
 * App\Models\Allergie
 *
 * @property int $id
 * @property string $description
 * @property string|null $date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string $slug
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\DossierMedical[] $dossiers
 * @property-read int|null $dossiers_count
 * @property-read mixed $description_and_timestamp
 * @method static \Illuminate\Database\Eloquent\Builder|Allergie findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|Allergie newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Allergie newQuery()
 * @method static \Illuminate\Database\Query\Builder|Allergie onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Allergie query()
 * @method static \Illuminate\Database\Eloquent\Builder|Allergie whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Allergie whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Allergie whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Allergie whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Allergie whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Allergie whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Allergie whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Allergie withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Allergie withoutTrashed()
 * @mixin \Eloquent
 */
class Allergie extends Model
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
                'source' => 'DescriptionAndTimestamp'
            ]
        ];
    }
    public function getDescriptionAndTimestampAttribute() {
        return substr($this->description,0,5). ' ' .Carbon::now()->timestamp;
    }

    protected $fillable = [
        "description",
        "date",
        'slug'
    ];


    public  function  dossiers(){
        return $this->belongsToMany(DossierMedical::class,'dossier_allergie','allergie_id','dossier_medical_id');
    }

    public function updateAllergyItem(){
        if(!is_null($this)) {
            $connectedUser = Auth::user();
            if ($connectedUser->getRoleNames()->first() == 'Medecin controle' || $connectedUser->getRoleNames()->first() == 'Praticien') {
                $this['isAuthor'] = true;
            }
            $this['dossier'] = $this->dossiers->first();
            if (!is_null($this->dossiers->first())) {
                $this['patient'] = $this->dossiers->first()->patient;
                $this['user'] = $this->dossiers->first()->patient->user;
            }
        }
    }
}
