<?php

namespace App\Models;

use App\Models\Traits\SlugRoutable;
use App\Scopes\RestrictArchivedAt;
use App\Scopes\RestrictResultatScope;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\ResultatImagerie
 *
 * @property int $id
 * @property int $dossier_medical_id
 * @property string $consultation_medecine_generale_id
 * @property string $description
 * @property string $date
 * @property string|null $file
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $archived_at
 * @property \Illuminate\Support\Carbon|null $passed_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int|null $praticien_id
 * @property-read \App\Models\ConsultationMedecineGenerale $consultation
 * @property-read \App\Models\DossierMedical $dossier
 * @property-read mixed $type_and_timestamp
 * @method static \Illuminate\Database\Eloquent\Builder|ResultatImagerie findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|ResultatImagerie newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ResultatImagerie newQuery()
 * @method static \Illuminate\Database\Query\Builder|ResultatImagerie onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ResultatImagerie query()
 * @method static \Illuminate\Database\Eloquent\Builder|ResultatImagerie whereArchivedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ResultatImagerie whereConsultationMedecineGeneraleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ResultatImagerie whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ResultatImagerie whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ResultatImagerie whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ResultatImagerie whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ResultatImagerie whereDossierMedicalId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ResultatImagerie whereFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ResultatImagerie whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ResultatImagerie wherePassedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ResultatImagerie wherePraticienId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ResultatImagerie whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ResultatImagerie whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|ResultatImagerie withTrashed()
 * @method static \Illuminate\Database\Query\Builder|ResultatImagerie withoutTrashed()
 * @mixin \Eloquent
 */
class ResultatImagerie extends Model
{
    use SoftDeletes;
    use Sluggable;
    use SluggableScopeHelpers;
    use SlugRoutable;

    /**
     * Attributes that are mass assignable
     */
    protected $fillable = [
        "dossier_medical_id",
        "consultation_medecine_generale_id",

        "type",
        "description",
        "date",
        "file",
        'slug',
        "praticien_id"
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'archived_at',
        'passed_at',
        'deleted_at'
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
                'source' => 'TypeAndTimestamp'
            ]
        ];
    }

    public function getTypeAndTimestampAttribute() {
        return $this->type . ' ' . Carbon::now()->timestamp;
    }

    public function dossier(){
        return $this->belongsTo(DossierMedical::class,'dossier_medical_id','id');
    }

    public function consultation(){
        return $this->belongsTo(ConsultationMedecineGenerale::class,'consultation_medecine_generale_id','id');
    }

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new RestrictResultatScope);
        static::addGlobalScope(new RestrictArchivedAt);

    }
}
