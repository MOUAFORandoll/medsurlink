<?php

namespace App\Models;

use App\Models\Traits\SlugRoutable;
use App\User;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Str;

/**
 * App\Models\MedecinControle
 *
 * @property string $slug
 * @property int $specialite_id
 * @property int|null $user_id
 * @property string $civilite
 * @property string|null $numero_ordre
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $signature
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Auteur[] $auteurs
 * @property-read int|null $auteurs_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\DelaiOperation[] $delai_operations
 * @property-read int|null $delai_operations_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\EtablissementExercice[] $etablissements
 * @property-read int|null $etablissements_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Patient[] $patients
 * @property-read int|null $patients_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\RendezVous[] $rendezVous
 * @property-read int|null $rendez_vous_count
 * @property-read \App\Models\Specialite $specialite
 * @property-read User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|MedecinControle findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|MedecinControle newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MedecinControle newQuery()
 * @method static \Illuminate\Database\Query\Builder|MedecinControle onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|MedecinControle query()
 * @method static \Illuminate\Database\Eloquent\Builder|MedecinControle whereCivilite($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedecinControle whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedecinControle whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedecinControle whereNumeroOrdre($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedecinControle whereSignature($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedecinControle whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedecinControle whereSpecialiteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedecinControle whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedecinControle whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|MedecinControle withTrashed()
 * @method static \Illuminate\Database\Query\Builder|MedecinControle withoutTrashed()
 * @mixin \Eloquent
 */
class MedecinControle extends Model
{
    use SoftDeletes;
    use Sluggable;
    use SluggableScopeHelpers;
    use SlugRoutable;

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'user.slug'
            ]
        ];
    }
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
        "numero_ordre",
        "civilite",
        'slug',
        'signature'
    ];

    protected $appends = ['name'];

    public function getNameAttribute(){
        return $this->civilite . ' ' . ucfirst($this->user->prenom ?? '') . ' ' . Str::upper($this->user->nom ?? '');
    }

    public function specialite(){
        return $this->belongsTo(Specialite::class,'specialite_id','id');
    }

    public function auteurs()
    {
        return $this->morphMany(Auteur::class, 'auteurable');
    }
    public function user(){
        return $this->belongsTo(User::class,'user_id','id')->withTrashed();
    }

    public function etablissements(){
        return $this->belongsToMany(EtablissementExercice::class,'etablissement_exercice_medecin','medecin_controle_id','etablissement_id');
    }
    public function patients(){
        return $this->belongsToMany(Patient::class, 'patient_medecin_controles', 'medecin_control_id',  'patient_id');
    }

    public function rendezVous(){
        return $this->hasMany(RendezVous::class, 'praticien_id', 'user_id');
    }

    public function delai_operations()
    {
        return $this->morphMany(DelaiOperation::class, 'delai_operationable');
    }
}
