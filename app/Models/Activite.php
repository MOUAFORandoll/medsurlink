<?php

namespace App\Models;

use App\User;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class Activite extends Model
{
    use Sluggable;
    use SoftDeletes;

    protected $fillable = [
        'groupe_id',
        'creator',
        'statut',
        'date_cloture',
        'slug',
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

    public static function boot()
    {
        parent::boot(); // TODO: Change the autogenerated stub

        Activite::creating(function ($activite){
            $activite->creator = Auth::id();
        });

    }

    public function getDossierAndTimestampAttribute() {
        return Str::random(10) . ' ' .Carbon::now()->timestamp;
    }

    public function groupe(){
        return $this->belongsTo(GroupeActivite::class,'groupe_id','id');
    }

    public function createur(){
        return $this->belongsTo(User::class,'creator','id');
    }

    public function missions(){
        return $this->hasMany(ActiviteMission::class,'activite_id','id');
    }

}
