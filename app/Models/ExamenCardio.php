<?php

namespace App\Models;

use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class ExamenCardio extends Model
{
    use Sluggable;
    use SoftDeletes;

    protected $fillable = [
        "cardiologie_id",
        "nom",
        "date_examen",
        "description",
        "slug",
        "ligne_de_temps_id"
    ];

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'NomAndTimestamp'
            ]
        ];
    }

    public function getNomAndTimestampAttribute() {
        return $this->nom . ' ' .Carbon::now()->timestamp;
    }

    public function cardiologie(){
        return $this->belongsTo(Cardiologie::class,'cardiologie_id','id');
    }

    public function updateExamen(){
        $isAuthor = checkIfIsAuthorOrIsAuthorized("ExamenCardio",$this->id,"create");
        $canUpdate = checkIfCanUpdated("ExamenCardio",$this->id,"create");
        $this['isAuthor']=$isAuthor->getOriginalContent();
        $connectedUser = Auth::user();
        if ($connectedUser->getRoleNames()->first() == 'Praticien'){
            $this['canUpdate']=$canUpdate->getOriginalContent() && is_null($this->passed_at) && is_null($this->archieved_at);
        }elseif ($connectedUser->getRoleNames()->first() == 'Medecin controle'){
            if ($isAuthor->getOriginalContent() == true)
                $this['canUpdate'] = is_null($this->archieved_at);
            else{
                $this['canUpdate']=$canUpdate->getOriginalContent() && !is_null($this->passed_at) && is_null($this->archieved_at);
            }
        }elseif($connectedUser->getRoleNames()->first() == 'Admin'){
            $this['canUpdate']=true;
        }
    }
}
