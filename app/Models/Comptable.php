<?php

namespace App\Models;

use App\User;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class Comptable extends Model
{
    use SoftDeletes;
    use Sluggable;

    protected $fillable = ['user_id','etablissement_id','sexe','slug'];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'ReferenceAndTimestamp'
            ]
        ];
    }

    public static function boot()
    {
        parent::boot(); // TODO: Change the autogenerated stub

        Comptable::creating(function ($comptable){

            $comptable->creator = Auth::id();
        });

    }

    public function getReferenceAndTimestampAttribute() {
        return Str::random(6) . ' ' .Carbon::now()->timestamp;
    }

    public function etablissements(){
        return $this->belongsTo(EtablissementExercice::class,'etablissement_id','id');
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }

}
