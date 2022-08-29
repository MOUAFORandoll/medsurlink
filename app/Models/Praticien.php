<?php

namespace App\Models;

use App\Models\Traits\SlugRoutable;
use App\User;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Praticien
 *
 * @property int|null $user_id
 * @property int $specialite_id
 * @property string $civilite
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string|null $numero_ordre
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $slug
 * @property string|null $signature
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Auteur[] $auteurs
 * @property-read int|null $auteurs_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\EtablissementExercice[] $etablissements
 * @property-read int|null $etablissements_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\RendezVous[] $rendezVous
 * @property-read int|null $rendez_vous_count
 * @property-read \App\Models\Specialite $specialite
 * @property-read User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|Praticien findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|Praticien newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Praticien newQuery()
 * @method static \Illuminate\Database\Query\Builder|Praticien onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Praticien query()
 * @method static \Illuminate\Database\Eloquent\Builder|Praticien whereCivilite($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Praticien whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Praticien whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Praticien whereNumeroOrdre($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Praticien whereSignature($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Praticien whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Praticien whereSpecialiteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Praticien whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Praticien whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|Praticien withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Praticien withoutTrashed()
 * @mixin \Eloquent
 */
class Praticien extends Model
{
    use SoftDeletes;
    use Sluggable;
    use SluggableScopeHelpers;
    use SlugRoutable;
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
        "specialite_id",
        "civilite",
        "numero_ordre",
        'slug',
        'signature'

    ];

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'user.slug'
            ]
        ];
    }

    public function etablissements(){
        return $this->belongsToMany(EtablissementExercice::class,'etablissement_exercice_praticien','praticien_id','etablissement_id');
    }

    public function specialite(){
        return $this->belongsTo(Specialite::class,'specialite_id','id');
    }

    public function auteurs()
    {
        return $this->morphMany(Auteur::class, 'auteurable');
    }
    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function rendezVous(){
       return $this->hasMany(RendezVous::class, 'praticien_id', 'user_id');
    }

}
