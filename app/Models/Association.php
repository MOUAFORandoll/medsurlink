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
 * App\Models\Association
 *
 * @property int $id
 * @property int|null $creator
 * @property int|null $responsable
 * @property string|null $region
 * @property string|null $ville
 * @property string|null $nom
 * @property string|null $telephone
 * @property string|null $localisation
 * @property string|null $email
 * @property string|null $contact
 * @property string|null $slug
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read User|null $author
 * @property-read mixed $dossier_and_timestamp
 * @property-read User|null $userResponsable
 * @method static \Illuminate\Database\Eloquent\Builder|Association findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|Association newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Association newQuery()
 * @method static \Illuminate\Database\Query\Builder|Association onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Association query()
 * @method static \Illuminate\Database\Eloquent\Builder|Association whereContact($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Association whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Association whereCreator($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Association whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Association whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Association whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Association whereLocalisation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Association whereNom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Association whereRegion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Association whereResponsable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Association whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Association whereTelephone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Association whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Association whereVille($value)
 * @method static \Illuminate\Database\Query\Builder|Association withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Association withoutTrashed()
 * @mixin \Eloquent
 */
class Association extends Model
{
    use Sluggable;
    use SoftDeletes;

    protected $fillable = [
        "creator",
        "region",
        "ville",
        "nom",
        "telephone",
        "localisation",
        "email",
        "contact",
        "responsable",
        "slug",
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

    public function author (){
        return $this->belongsTo(User::class,'creator','id');
    }
    public function userResponsable(){
        return $this->belongsTo(User::class,'responsable','id');
    }
    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();


        Association::creating(function ($association){
            $association->creator = Auth::id();
        });
    }
}
