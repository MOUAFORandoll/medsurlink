<?php

namespace App\Models;

use App\Models\Traits\SlugRoutable;
use App\Scopes\RestrictConsultationObstetriqueScope;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Echographie
 *
 * @property int $id
 * @property int $consultation_obstetrique_id
 * @property string $date_creation
 * @property string $type
 * @property string $ddr
 * @property string $dpa
 * @property int|null $semaine_amenorrhee
 * @property string|null $biometrie
 * @property string|null $annexe
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $slug
 * @property string|null $archieved_at
 * @property string|null $passed_at
 * @property-read \App\Models\ConsultationObstetrique $consultation
 * @property-read mixed $type_and_timestamp
 * @method static \Illuminate\Database\Eloquent\Builder|Echographie findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|Echographie newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Echographie newQuery()
 * @method static \Illuminate\Database\Query\Builder|Echographie onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Echographie query()
 * @method static \Illuminate\Database\Eloquent\Builder|Echographie whereAnnexe($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Echographie whereArchievedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Echographie whereBiometrie($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Echographie whereConsultationObstetriqueId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Echographie whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Echographie whereDateCreation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Echographie whereDdr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Echographie whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Echographie whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Echographie whereDpa($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Echographie whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Echographie wherePassedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Echographie whereSemaineAmenorrhee($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Echographie whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Echographie whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Echographie whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Echographie withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Echographie withoutTrashed()
 * @mixin \Eloquent
 */
class Echographie extends Model
{
    use SoftDeletes;

    protected $fillable = [
        "consultation_obstetrique_id",
        "date_creation",
        "type",
        "ddr",
        "dpa",
        "semaine_amenorrhee",
        "biometrie",
        "annexe",
        "description",
        'slug',
        "ligne_de_temps_id"
    ];
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
    public function consultation(){
        return $this->belongsTo(ConsultationObstetrique::class,'consultation_obstetrique_id','id');
    }
    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new RestrictConsultationObstetriqueScope);
    }

    public function updateEchographie(){
        if (!is_null($this)){
            $isAuthor = checkIfIsAuthorOrIsAuthorized("Echographie",$this->id,"create");
            $this['isAuthor'] = $isAuthor->getOriginalContent();
        }
    }
}
