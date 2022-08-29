<?php

namespace App\Models;

use App\User;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

/**
 * App\Models\Ordonance
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon $date_prescription
 * @property \Illuminate\Support\Carbon|null $archieved_at
 * @property \Illuminate\Support\Carbon|null $passed_at
 * @property int $dossier_medical_id
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $praticien_id
 * @property-read \App\Models\DossierMedical $dossier
 * @property-read mixed $dossier_and_timestamp
 * @property-read \App\Models\LigneDeTemps $ligneDeTemps
 * @property-read User|null $praticien
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Prescription[] $prescriptions
 * @property-read int|null $prescriptions_count
 * @method static \Illuminate\Database\Eloquent\Builder|Ordonance findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|Ordonance newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Ordonance newQuery()
 * @method static \Illuminate\Database\Query\Builder|Ordonance onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Ordonance query()
 * @method static \Illuminate\Database\Eloquent\Builder|Ordonance whereArchievedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ordonance whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ordonance whereDatePrescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ordonance whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ordonance whereDossierMedicalId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ordonance whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ordonance wherePassedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ordonance wherePraticienId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ordonance whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ordonance whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Ordonance withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Ordonance withoutTrashed()
 * @mixin \Eloquent
 */
class Ordonance extends Model
{
    use SoftDeletes;
    use Sluggable;
    use SluggableScopeHelpers;

    protected $fillable = [
        "slug",
        "dossier_medical_id",
        "date_prescription",
        "praticien_id",
        "archieved_at",
        "passed_at",
        "ligne_de_temps_id"
    ];
    protected $dates = [
        "date_prescription",
        "archieved_at",
        "passed_at",
    ];

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'DossierAndTimestamp'
            ]
        ];
    }
    public function ligneDeTemps(){
        return $this->belongsTo(LigneDeTemps::class,'ligne_de_temps_id','id');
    }
    public function getDossierAndTimestampAttribute() {
        return $this->dossier->slug.''.Carbon::now()->timestamp;
    }

    public function dossier(){
        return $this->belongsTo(DossierMedical::class,'dossier_medical_id','id');
    }

    public function updateOrdonance(){
        $isAuthor = checkIfIsAuthorOrIsAuthorized('Ordonance',$this->id,'create');
        $this['isAuthor']=$isAuthor->getOriginalContent();
        $connectedUser = Auth::user();
        if ($connectedUser->getRoleNames()->first() == 'Medecin controle'){
            $this['isAuthor']=true;
        }
    }

    public function praticien(){
        return $this->belongsTo(User::class,'praticien_id','id');
    }

    public function prescriptions(){
        return $this->hasMany(Prescription::class,'ordonance_id','id');
    }

}
