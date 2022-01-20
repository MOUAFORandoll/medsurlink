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
