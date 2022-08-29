<?php

namespace App\Models;

use App\Models\Traits\SlugRoutable;
use App\User;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

/**
 * App\Models\Gestionnaire
 *
 * @property string $slug
 * @property int|null $user_id
 * @property string $civilite
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Auteur[] $auteurs
 * @property-read int|null $auteurs_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Auteur[] $operations
 * @property-read int|null $operations_count
 * @property-read User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|Gestionnaire findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|Gestionnaire newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Gestionnaire newQuery()
 * @method static \Illuminate\Database\Query\Builder|Gestionnaire onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Gestionnaire query()
 * @method static \Illuminate\Database\Eloquent\Builder|Gestionnaire whereCivilite($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Gestionnaire whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Gestionnaire whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Gestionnaire whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Gestionnaire whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Gestionnaire whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|Gestionnaire withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Gestionnaire withoutTrashed()
 * @mixin \Eloquent
 */
class Gestionnaire extends Model
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
        "civilite",
        'slug'
    ];

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'user.slug'
            ]
        ];
    }
    /**
     * Get all of the gestionnaire action.
     */
    public function auteurs()
    {
        return $this->morphMany(Auteur::class, 'auteurable');
    }

    /**
     * Get all of the gestionnaire action.
     */
    public function operations()
    {
        return $this->morphMany(Auteur::class, 'operationable');
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function updateGestionnaire(){
        if (!is_null($this)){
            $isAuthor = checkIfIsAuthorOrIsAuthorized("Gestionnaire",$this->user_id,"create");
            if ($this->user_id == Auth::id()){
                $this['isAuthor']=true;
            } else{
                $this['isAuthor']=$isAuthor->getOriginalContent();
            }
        }
    }
}
