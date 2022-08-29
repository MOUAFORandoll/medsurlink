<?php

namespace App\Models;

use Carbon\Carbon;
use App\User;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

/**
 * App\Models\FactureAvis
 *
 * @property int $id
 * @property int $avis_id
 * @property int $dossier_medical_id
 * @property int $association_id
 * @property int $etablissement_id
 * @property int|null $creator
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Association $association
 * @property-read \App\Models\Avis $avis
 * @property-read User|null $createur
 * @property-read \App\Models\DossierMedical $dossier
 * @property-read \App\Models\EtablissementExercice $etablissement
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\FactureAvisDetail[] $factureDetail
 * @property-read int|null $facture_detail_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\File[] $files
 * @property-read int|null $files_count
 * @property-read mixed $name_and_timestamp
 * @method static \Illuminate\Database\Eloquent\Builder|FactureAvis findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|FactureAvis newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FactureAvis newQuery()
 * @method static \Illuminate\Database\Query\Builder|FactureAvis onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|FactureAvis query()
 * @method static \Illuminate\Database\Eloquent\Builder|FactureAvis whereAssociationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FactureAvis whereAvisId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FactureAvis whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FactureAvis whereCreator($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FactureAvis whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FactureAvis whereDossierMedicalId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FactureAvis whereEtablissementId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FactureAvis whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FactureAvis whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FactureAvis whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|FactureAvis withTrashed()
 * @method static \Illuminate\Database\Query\Builder|FactureAvis withoutTrashed()
 * @mixin \Eloquent
 */
class FactureAvis extends Model
{
    use SoftDeletes;
    use Sluggable;

    protected $fillable = [
        "avis_id",
        "association_id",
        "etablissement_id",
        "dossier_medical_id",
        "slug",
        "creator",
    ];

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'NameAndTimestamp'
            ]
        ];
    }

    public static function boot()
    {
        parent::boot(); // TODO: Change the autogenerated stub
        //On définit le créateur à la création du suivi
        Suivi::creating(function ($factureAvis){
            $factureAvis->creator = Auth::id();
        });
    }

    public function getNameAndTimestampAttribute() {
        return Str::random(16).' '.Carbon::now()->timestamp;
    }

    public function avis(){
        return $this->belongsTo(Avis::class,'avis_id','id');
    }

    public function association(){
        return $this->belongsTo(Association::class,'association_id','id');
    }

    public function dossier(){
        return $this->belongsTo(DossierMedical::class,'dossier_medical_id','id');
    }

    public function factureDetail(){
        return $this->hasMany(FactureAvisDetail::class,'facture_avis_id','id');
    }
    public function createur(){
        return $this->belongsTo(User::class,'creator','id');
    }

    public function files(){
        return $this->morphMany(File::class,'fileable');
    }

    public function etablissement(){
        return $this->belongsTo(EtablissementExercice::class,'etablissement_id','id');
    }
}