<?php

namespace App\Models;

use App\User;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use App\Models\ActivitesMedecinReferent;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;

class ActivitesControle extends Model
{
    use Sluggable;
    use SoftDeletes;

    protected $table = 'activites_controle';
    protected $fillable = [
        "activite_id",
        "creator",
        "commentaire",
        "statut",
        "date_cloture",
        "slug",
    ];

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

    public function activite(){
        return $this->belongsTo(ActivitesMedecinReferent::class,'activite_id','id');
    }
    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }
    public function createur(){
        return $this->belongsTo(User::class,'creator','id');
    }
}
