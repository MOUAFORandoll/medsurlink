<?php

namespace App\Models;

use App\Models\Traits\SlugRoutable;
use App\User;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Netpok\Database\Support\RestrictSoftDeletes;

/**
 * App\Models\Souscripteur
 *
 * @property int|null $user_id
 * @property string|null $sexe
 * @property string|null $date_de_naissance
 * @property int|null $age
 * @property int $consentement
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\AffiliationSouscripteur[] $affiliation
 * @property-read int|null $affiliation_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Auteur[] $auteurs
 * @property-read int|null $auteurs_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\PatientSouscripteur[] $financeurs
 * @property-read int|null $financeurs_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Patient[] $patients
 * @property-read int|null $patients_count
 * @property-read User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|Souscripteur findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|Souscripteur newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Souscripteur newQuery()
 * @method static \Illuminate\Database\Query\Builder|Souscripteur onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Souscripteur query()
 * @method static \Illuminate\Database\Eloquent\Builder|Souscripteur whereAge($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Souscripteur whereConsentement($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Souscripteur whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Souscripteur whereDateDeNaissance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Souscripteur whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Souscripteur whereSexe($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Souscripteur whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Souscripteur whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Souscripteur whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|Souscripteur withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Souscripteur withoutTrashed()
 * @mixin \Eloquent
 */
class Souscripteur extends Model
{
    use SoftDeletes;
    use RestrictSoftDeletes;
    use Sluggable;
    use SluggableScopeHelpers;
    use SlugRoutable;
    /**
     * The relations restricting model deletion
     */
    protected $restrictDeletes = ['patients'];

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'user_id';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    protected $fillable = [
        "user_id",
        "sexe",
        "date_de_naissance",
        "consentement",
        "age",
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
                'source' => 'user.slug'
            ]
        ];
    }
    public function patients(){
        return $this->hasMany(Patient::class,'souscripteur_id','user_id');
    }
    public function affiliation(){
        return $this->hasMany(AffiliationSouscripteur::class,'user_id','user_id');
    }
    public function auteurs()
    {
        return $this->morphMany(Auteur::class, 'auteurable');
    }

    public function financeurs()
    {
        return $this->morphMany(PatientSouscripteur::class, 'financable');
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function updatePatientDossier(){
        if ($this->financeurs){
            foreach ($this->financeurs as $financeur){
                $this->patients->push($financeur->patients);
            }
        }
    }

}
