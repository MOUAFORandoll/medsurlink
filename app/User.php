<?php

namespace App;

use App\Models\DossierMedical;
use App\Models\Gestionnaire;
use App\Models\MedecinControle;
use App\Models\Patient;
use App\Models\Praticien;
use App\Models\Souscripteur;
use App\Models\Traits\SlugRoutable;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use http\Env\Response;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Passport\HasApiTokens;
use Netpok\Database\Support\RestrictSoftDeletes;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use SoftDeletes;
    use Notifiable;
    use HasApiTokens;
    use HasRoles;
    use Sluggable;
    use SluggableScopeHelpers;
    use SlugRoutable;
    use RestrictSoftDeletes;

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
        'slug'
    ];

    /**
     * The relations restricting model deletion
     */
    protected $restrictDeletes = [
        'praticien',
        'patient',
        'gestionnaire',
        'souscripteur',
        'medecinControle',
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
                'source' => 'NomAndTimestamp'
            ]
        ];
    }
    public function getNomAndTimestampAttribute() {
        return $this->nom . ' ' .Carbon::now()->timestamp;
    }

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

    /**
     * Validate the password of the user for the Passport password grant.
     *
     * @param  string $password
     * @return bool
     */
    public function validateForPassportPasswordGrant($password)
    {
        return Hash::check($password, $this->password);
    }

    /**
     * Find the user instance for the given username.
     *
     * @param  string  $username
     * @return \App\User
     */
    public function findForPassport($username)
    {
        //Verification de l'existence de l'adresse email
        $validator = Validator::make(compact('username'),['username'=>['exists:users,email']]);
        if($validator->fails()){
            //Verification de l'existence du numero de dossier
            if (strlen($username)==8){
                $numero_dossier = $username;
                $dossier = DossierMedical::with('patient')->whereNumeroDossier($numero_dossier)->first();
                return $dossier->patient->user;
            }

            return [];
        }
        return  $this->where('email', $username)->first();
    }

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
