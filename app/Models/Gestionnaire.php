<?php

namespace App\Models;

use App\Models\Traits\SlugRoutable;
use App\User;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

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
