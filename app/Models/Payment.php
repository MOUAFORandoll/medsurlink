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
 * App\Models\Payment
 *
 * @property int $id
 * @property int $souscripteur_id
 * @property int $patient_id
 * @property string|null $amount
 * @property string|null $date_payment
 * @property string $method
 * @property string $motif
 * @property string $statut
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $date_facturation
 * @property-read \App\Models\Patient $patients
 * @property-read \App\Models\Souscripteur $souscripteur
 * @method static \Illuminate\Database\Eloquent\Builder|Payment findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Payment newQuery()
 * @method static \Illuminate\Database\Query\Builder|Payment onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Payment query()
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereDateFacturation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereDatePayment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereMotif($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereSouscripteurId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereStatut($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Payment withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Payment withoutTrashed()
 * @mixin \Eloquent
 */
class Payment extends Model
{
    use SoftDeletes;
    use Sluggable;

    /**
     * The relations restricting model deletion
     */
    protected $restrictDeletes = ['payments'];

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';


    protected $fillable = [
        "uuid",
        "motif",
        "amount",
        "souscripteur_id",
        "patient_id",
        "date_payment",
        "date_facturation",
        "statut",
        "method",
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
                'source' => 'TypeAndTimestamp'
            ]
        ];
    }
    public function patients(){
        return $this->belongsTo(Patient::class,'patient_id','user_id');
    }

    public function souscripteur(){
        return $this->belongsTo(Souscripteur::class,'souscripteur_id','user_id');
    }
}
