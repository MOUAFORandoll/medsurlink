<?php

namespace App;

use App\Models\Gestionnaire;
use App\Models\MedecinControle;
use App\Models\Patient;
use App\Models\Praticien;
use App\Models\Souscripteur;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable;
    use HasApiTokens;
    use HasRoles;

    protected $guard_name = 'api';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nom',
        'email',
        'prenom',
        'nationalite',
        'quartier',
        'code_postal',
        'ville',
        'pays',
        'telephone',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function praticien(){
        return $this->hasOne(Praticien::class,'user_id','id');
    }
    public function patient(){
        return $this->hasOne(Patient::class,'user_id','id');
    }
    public function gestionnaire(){
        return $this->hasOne(Gestionnaire::class,'user_id','id');
    }
    public function souscripteur(){
        return $this->hasOne(Souscripteur::class,'user_id','id');
    }
    public function medecinControle(){
        return $this->hasOne(MedecinControle::class,'user_id','id');
    }
}
