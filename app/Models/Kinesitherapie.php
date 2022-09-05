<?php

namespace App\Models;

use App\Scopes\RestrictArchievedAt;
use App\Scopes\RestrictDossierScope;
use App\User;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

/**
 * App\Models\Kinesitherapie
 *
 * @property int $id
 * @property int $etablissement_id
 * @property int|null $creator
 * @property int $dossier_medical_id
 * @property string|null $date_consultation
 * @property string|null $motifs
 * @property string|null $anamnese
 * @property string|null $profession
 * @property string|null $evaluation_globale
 * @property string|null $impression_diagnostique
 * @property string|null $examens_complementaires
 * @property string|null $conduite_a_tenir
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $archieved_at
 * @property string|null $passed_at
 * @property-read User|null $author
 * @property-read \App\Models\DossierMedical $dossier
 * @property-read \App\Models\EtablissementExercice $etablissement
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\File[] $files
 * @property-read int|null $files_count
 * @property-read mixed $dossier_and_timestamp
 * @property-read \App\Models\LigneDeTemps $ligneDeTemps
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Contributeurs[] $operationables
 * @property-read int|null $operationables_count
 * @property-read \App\Models\RendezVous|null $rdv
 * @method static \Illuminate\Database\Eloquent\Builder|Kinesitherapie findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|Kinesitherapie newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Kinesitherapie newQuery()
 * @method static \Illuminate\Database\Query\Builder|Kinesitherapie onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Kinesitherapie orderByDateConsultation()
 * @method static \Illuminate\Database\Eloquent\Builder|Kinesitherapie query()
 * @method static \Illuminate\Database\Eloquent\Builder|Kinesitherapie whereAnamnese($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kinesitherapie whereArchievedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kinesitherapie whereConduiteATenir($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kinesitherapie whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kinesitherapie whereCreator($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kinesitherapie whereDateConsultation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kinesitherapie whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kinesitherapie whereDossierMedicalId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kinesitherapie whereEtablissementId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kinesitherapie whereEvaluationGlobale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kinesitherapie whereExamensComplementaires($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kinesitherapie whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kinesitherapie whereImpressionDiagnostique($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kinesitherapie whereMotifs($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kinesitherapie wherePassedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kinesitherapie whereProfession($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kinesitherapie whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kinesitherapie whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Kinesitherapie withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Kinesitherapie withoutTrashed()
 * @mixin \Eloquent
 */
class Kinesitherapie extends Model
{
    use Sluggable;
    use SoftDeletes;

    protected $fillable = [
      "etablissement_id",
      "creator",
      "dossier_medical_id",
      "date_consultation",
      "motifs",
      "anamnese",
      "profession",
      "evaluation_globale",
      "impression_diagnostique",
      "examens_complementaires",
      "conduite_a_tenir",
      "slug",
      "archieved_at",
      "passed_at",
      "ligne_de_temps_id"
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
                'source' => 'DossierAndTimestamp'
            ]
        ];
    }
    public function getDossierAndTimestampAttribute() {
        return Str::random(10) . ' ' .Carbon::now()->timestamp;
    }

    public function dossier(){
        return $this->belongsTo(DossierMedical::class,'dossier_medical_id','id');
    }
    public function ligneDeTemps(){
        return $this->belongsTo(LigneDeTemps::class,'ligne_de_temps_id','id');
    }
    public function etablissement(){
        return $this->belongsTo(EtablissementExercice::class,'etablissement_id','id');
    }

    public function author (){
        return $this->belongsTo(User::class,'creator','id');
    }

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new RestrictDossierScope);
        static::addGlobalScope(new RestrictArchievedAt);

        Kinesitherapie::creating(function ($consultation){
            $consultation->creator = Auth::id();
        });
    }

    public function operationables(){
        return $this->morphMany(Contributeurs::class,'operationable');
    }

    public function files(){
        return $this->morphMany(File::class,'fileable');
    }


    public function rdv(){
        return $this->morphOne(RendezVous::class,'sourceable');
    }

    public function scopeOrderByDateConsultation($query)
    {
        return $query->orderBy('date_consultation', 'desc');
    }

    public function updateConsultation(){
        $this['isAuthor']=$this->creator == Auth::id();
        $connectedUser = Auth::user();
        if ($connectedUser->getRoleNames()->first() == 'Praticien'){
            $this['canUpdate']=$this['isAuthor'] && is_null($this->passed_at) && is_null($this->archieved_at);
        }elseif ($connectedUser->getRoleNames()->first() == 'Medecin controle'){
            $this['isAuthor'] == true;
            if ($this['isAuthor'] == true)
                $this['canUpdate'] = is_null($this->archieved_at);
            else{
                $this['canUpdate']= !is_null($this->passed_at) && is_null($this->archieved_at);
            }
        }elseif($connectedUser->getRoleNames()->first() == 'Admin'){
            $this['canUpdate']=true;
        }
    }
}
