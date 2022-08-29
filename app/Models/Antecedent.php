<?php

namespace App\Models;

use App\Models\Traits\SlugRoutable;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

/**
 * App\Models\Antecedent
 *
 * @property int $id
 * @property int $dossier_medical_id
 * @property string $description
 * @property string|null $date
 * @property string $type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string $slug
 * @property-read \App\Models\DossierMedical $dossier
 * @property-read mixed $type_and_timestamp
 * @method static \Illuminate\Database\Eloquent\Builder|Antecedent findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|Antecedent newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Antecedent newQuery()
 * @method static \Illuminate\Database\Query\Builder|Antecedent onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Antecedent query()
 * @method static \Illuminate\Database\Eloquent\Builder|Antecedent whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Antecedent whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Antecedent whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Antecedent whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Antecedent whereDossierMedicalId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Antecedent whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Antecedent whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Antecedent whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Antecedent whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Antecedent withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Antecedent withoutTrashed()
 * @mixin \Eloquent
 */
class Antecedent extends Model
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
                'source' => 'TypeAndTimestamp'
            ]
        ];
    }
    public function getTypeAndTimestampAttribute() {
        return $this->type . ' ' .Carbon::now()->timestamp;
    }
    protected $fillable = [
        "dossier_medical_id",
        "description",
        "date",
        "type",
        'slug'
    ];

    public function dossier(){
        return $this->belongsTo(DossierMedical::class,'dossier_medical_id','id');
    }

    public function updateAntecedentItem(){
        if(!is_null($this)) {
            $isAuthor = checkIfIsAuthorOrIsAuthorized("Antecedent", $this->id, "create");
            $this['user'] = isset($this->dossier->patient) ? $this->dossier->patient->user : null;
            $this['isAuthor'] = $isAuthor->getOriginalContent();
            $connectedUser = Auth::user();
            if ($connectedUser->getRoleNames()->first() == 'Medecin controle' || $connectedUser->getRoleNames()->first() == 'Praticien') {
                $this['isAuthor'] = true;
            }
        }
    }

}
