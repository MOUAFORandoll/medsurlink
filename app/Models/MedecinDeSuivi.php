<?php

namespace App\Models;

use App\User;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Psy\Util\Str;

class MedecinDeSuivi extends Model
{
    use SoftDeletes;
    use Sluggable;

    protected $fillable = ['user_id','suivi_id','slug'];

    public function sluggable()
    {
        return [
            'slug' => [
                'source' =>'DossierAndTimestamp'
            ]
        ];
    }

    public function getDossierAndTimestampAttribute() {
        return \Illuminate\Support\Str::random(6) . ' ' .Carbon::now()->timestamp;
    }

    public function suivi(){
        return $this->belongsTo(Suivi::class,'suivi_id','id');
    }

    public function praticien(){
        return $this->belongsTo(User::class,'user_id','id');
    }
}
