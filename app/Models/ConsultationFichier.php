<?php

namespace App\Models;

use App\Scopes\RestrictArchievedAt;
use App\Scopes\RestrictArchivedAt;
use App\User;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

/**
 * App\Models\ConsultationFichier
 *
 * @property int $id
 * @property string $name
 * @property int $dossier_medical_id
 * @property int $etablissement_id
 * @property int $creator
 * @property string|null $user_id
 * @property string|null $passed_at
 * @property string|null $archieved_at
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $date_consultation
 * @property string|null $praticien_externe
 * @property string|null $consultation_externe
 * @property-read \App\Models\DossierMedical $dossier
 * @property-read \App\Models\EtablissementExercice $etablissement
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\File[] $files
 * @property-read int|null $files_count
 * @property-read mixed $dossier_and_timestamp
 * @property-read User|null $praticien
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationFichier findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationFichier newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationFichier newQuery()
 * @method static \Illuminate\Database\Query\Builder|ConsultationFichier onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationFichier query()
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationFichier whereArchievedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationFichier whereConsultationExterne($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationFichier whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationFichier whereCreator($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationFichier whereDateConsultation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationFichier whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationFichier whereDossierMedicalId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationFichier whereEtablissementId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationFichier whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationFichier whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationFichier wherePassedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationFichier wherePraticienExterne($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationFichier whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationFichier whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationFichier whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|ConsultationFichier withTrashed()
 * @method static \Illuminate\Database\Query\Builder|ConsultationFichier withoutTrashed()
 * @mixin \Eloquent
 */
class ConsultationFichier extends Model
{
    use SoftDeletes;
    use Sluggable;

    protected $fillable = [
        "name",
        "dossier_medical_id",
        "etablissement_id",
        'date_consultation',
        "user_id",
        "slug",
        "creator",
        "passed_at",
        "archieved_at",
        'praticien_externe',
        'consultation_externe'
    ];

    protected $hidden = ['creator','created_at','updated_at','deleted_at'];

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'DossierAndTimestamp'
            ]
        ];
    }

    public function getDossierAndTimestampAttribute() {
        return Str::random(6) . ' ' .Carbon::now()->timestamp;
    }

    public static function boot()
    {
        parent::boot(); // TODO: Change the autogenerated stub

        static::addGlobalScope(new RestrictArchievedAt);
        ConsultationFichier::creating(function ($consultation){
            $consultation->creator = Auth::id();
        });
    }

    public function dossier(){
        return $this->belongsTo(DossierMedical::class,'dossier_medical_id','id');
    }

    public function etablissement(){
        return $this->belongsTo(EtablissementExercice::class,'etablissement_id','id');
    }

    public function files(){
        return $this->morphMany(File::class,'fileable');
    }

    public function praticien(){
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function updateConsultation(){
        if(!is_null($this)){
           $this['isAuthor'] = ($this->creator == Auth::id() );
           $user  = Auth::user();
           $this['canUpdate'] = $user->getRoleNames()->first() == 'Medecin controle' || $this['isAuthor'];
        }
    }

    public function scopeConsultationFichierSemaineMoisAnnee($query, $intervalle_debut, $intervalle_fin)
    {
        return $query->where(function ($query) use($intervalle_debut, $intervalle_fin) {
            $query->whereDate('created_at', '>=', $intervalle_debut)->whereDate('created_at', '<=', $intervalle_fin);
        })->orderBy('created_at', 'asc');
    }
}
