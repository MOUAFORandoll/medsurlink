<?php

namespace App\Models;

use App\User;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class SpecialiteSuivi extends Model
{
    use SoftDeletes;
    use Sluggable;


    protected $fillable = [
        "suivi_id",
        "specialite_id",
        "responsable",
        "motifs",
        "slug",
        "creator",
        "etat",
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
                'source' => 'NameAndTimestamp'
            ]
        ];
    }


    public function getNameAndTimestampAttribute() {
        return Str::random(16).' '.Carbon::now()->timestamp;
    }

    public static function boot()
    {
        parent::boot(); // TODO: Change the autogenerated stub
        //On définit le créateur à la création du suivi
        SpecialiteSuivi::creating(function ($suivi){
            $suivi->creator = Auth::id();
        });
    }


    public function suivi(){
        return $this->belongsTo(Suivi::class,'suivi_id','id');
    }

    public function responsable(){
        return $this->belongsTo(User::class,'responsable','id');
    }

    public function createur(){
        return $this->belongsTo(User::class,'creator','id');
    }

    public function specialite(){
        return $this->belongsTo(ConsultationType::class,'specialite_id','id');
    }
}