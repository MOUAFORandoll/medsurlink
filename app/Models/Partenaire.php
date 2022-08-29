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
 * App\Models\Partenaire
 *
 * @property int $id
 * @property int|null $creator
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
 * @method static \Illuminate\Database\Eloquent\Builder|Partenaire findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|Partenaire newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Partenaire newQuery()
 * @method static \Illuminate\Database\Query\Builder|Partenaire onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Partenaire query()
 * @method static \Illuminate\Database\Eloquent\Builder|Partenaire whereContact($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Partenaire whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Partenaire whereCreator($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Partenaire whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Partenaire whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Partenaire whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Partenaire whereLocalisation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Partenaire whereNom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Partenaire whereRegion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Partenaire whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Partenaire whereTelephone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Partenaire whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Partenaire whereVille($value)
 * @method static \Illuminate\Database\Query\Builder|Partenaire withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Partenaire withoutTrashed()
 * @mixin \Eloquent
 */
class Partenaire extends Model
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

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();


        Partenaire::creating(function ($partenaire){
            $partenaire->creator = Auth::id();
        });
    }
}
