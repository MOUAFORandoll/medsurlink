<?php

namespace App;

use App\Models\Alerte;
use Carbon\Carbon;
use App\Models\Patient;
use App\Models\Praticien;
use App\Models\Assistante;
use App\Models\Pharmacien;
use App\Models\Association;
use App\Models\Gestionnaire;
use App\Models\Souscripteur;
use Illuminate\Http\Request;
use App\Models\Contributeurs;
use App\Models\DossierMedical;
use App\Models\MedecinAvis;
use App\Models\ReponseSecrete;
use App\Models\MedecinControle;
use App\Models\RendezVous;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\HasApiTokens;
use App\Models\Traits\SlugRoutable;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Validator;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Netpok\Database\Support\RestrictSoftDeletes;
use App\Notifications\MailResetPasswordNotification;
use App\Notifications\MedecinToPatient;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

/**
 * App\User
 *
 * @property int $id
 * @property string $nom
 * @property string|null $prenom
 * @property string|null $nationalite
 * @property string|null $quartier
 * @property string|null $code_postal
 * @property string|null $ville
 * @property string|null $pays
 * @property string $telephone
 * @property string|null $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string $slug
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string|null $adresse
 * @property int $isMedicasure
 * @property int $smsEnvoye
 * @property int $isNotice
 * @property string $decede
 * @property string|null $slack
 * @property-read Assistante|null $assistante
 * @property-read Association|null $association
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Passport\Client[] $clients
 * @property-read int|null $clients_count
 * @property-read \Illuminate\Database\Eloquent\Collection|Contributeurs[] $contributeurs
 * @property-read int|null $contributeurs_count
 * @property-read DossierMedical|null $dossier
 * @property-read Gestionnaire|null $gestionnaire
 * @property-read mixed $nom_and_timestamp
 * @property-read mixed $signature
 * @property-read \Illuminate\Database\Eloquent\Collection|MedecinAvis[] $medecinAvis
 * @property-read int|null $medecin_avis_count
 * @property-read MedecinControle|null $medecinControle
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\MediaLibrary\Models\Media[] $media
 * @property-read int|null $media_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Message[] $messages
 * @property-read int|null $messages_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read Patient|null $patient
 * @property-read \Illuminate\Database\Eloquent\Collection|Patient[] $patients
 * @property-read int|null $patients_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Permission[] $permissions
 * @property-read int|null $permissions_count
 * @property-read Pharmacien|null $pharmacien
 * @property-read Praticien|null $praticien
 * @property-read ReponseSecrete|null $questionSecrete
 * @property-read \Illuminate\Database\Eloquent\Collection|RendezVous[] $rendezVous
 * @property-read int|null $rendez_vous_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Role[] $roles
 * @property-read int|null $roles_count
 * @property-read Souscripteur|null $souscripteur
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Passport\Token[] $tokens
 * @property-read int|null $tokens_count
 * @method static \Illuminate\Database\Eloquent\Builder|User findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Query\Builder|User onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|User permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User role($roles, $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAdresse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCodePostal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDecede($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereIsMedicasure($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereIsNotice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereNationalite($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereNom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePays($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePrenom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereQuartier($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereSlack($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereSmsEnvoye($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTelephone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereVille($value)
 * @method static \Illuminate\Database\Query\Builder|User withTrashed()
 * @method static \Illuminate\Database\Query\Builder|User withoutTrashed()
 * @mixin \Eloquent
 */
class User extends Authenticatable implements HasMedia
{
    use HasMediaTrait;
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
        'isMedicasure',
        'email',
        'prenom',
        'nationalite',
        'quartier',
        'code_postal',
        'ville',
        'pays',
        'telephone',
        'password',
        'slug',
        'adresse',
        'smsEnvoye',
        'isNotice', // Permet de mentionner que le medecin est un medecin avis
        'slack',
        'decede',
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
        'assistante',
    ];

    protected $appends = ['signature', 'name'];

    protected $slackChannels= [
        'test' => 'https://hooks.slack.com/services/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',
        'test2' => 'https://hooks.slack.com/services/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',
        'affilie' => 'https://hooks.slack.com/services/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',
        'appel' => 'https://hooks.slack.com/services/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'
    ];

    protected $slack_url = null;

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

    // public function routeNotificationForSlack(){
    //     if($this->slack_url === null){
    //         return $this->slackChannels['affilie'];
    //     }
    //     return $this->slack_url;
    // }
    public function routeNotificationForSlack(){
        $env = strtolower(config('app.env'));
        if ($env == 'production')
            return $this->slackChannels["appel"];
        else
            return $this->slackChannels["test"];
    }

    public function getNameAttribute(){
        return ucfirst($this->prenom).' '.Str::upper($this->nom);
    }

    /**
     * @param $name
     * @return $this
     */
    public function setSlackChannel($name){
        if(isset($this->slackChannels[$name])){
            $this->setSlackUrl($this->slackChannels[$name]);
        }

        return $this;
    }

    /**
     * @param $url
     * @return $this
     */
    public function setSlackUrl($url){
        $this->slack_url = $url;

        return $this;
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
        $users = User::where('email', $this->email)->get();
        $passwordExist = false;
        foreach ($users as $user){
            if(Hash::check($password,$user->password)){
                $passwordExist = true;
                break;
            }
        }
        return $passwordExist;
    }

    /**
     * Find the user instance for the given username.
     *
     * @param  string  $username
     * @return \App\User
     */
    public function findForPassport($username)
    {
        $password = Request::capture()['password'];
        //Verification de l'existence de l'adresse email
        $validator = Validator::make(compact('username'),['username'=>['exists:users,email']]);
        if($validator->fails()){

            //Verification de l'existence du numero de dossier
            if (strlen($username)<=9){
                $numero_dossier = $username;
                $dossier = DB::table('dossier_medicals')->where('numero_dossier','=',$numero_dossier)->first();

                if (!is_null($dossier)){
                    $user = User::whereId($dossier->patient_id)->first();
                    return $user;

                }
                return [];
            }
            return [];
        }
        //Retourne tous l'utilisateur qui ont cette adresse email
        $users = User::where('email', $username)->get();
        $authUser = new User();
        foreach ($users as $user){
            if(Hash::check($password,$user->password)){
                $authUser = $user;
                break;
            }
        }
        return $authUser;
    }


    public function praticien(){
        return $this->hasOne(Praticien::class,'user_id','id')->withTrashed();
    }
    public function association(){
        return $this->hasOne(Association::class,'responsable','id');
    }
    public function patient(){
        return $this->hasOne(Patient::class,'user_id','id');
    }
    public function gestionnaire(){
        return $this->hasOne(Gestionnaire::class,'user_id','id')->withTrashed();
    }
    public function souscripteur(){
        return $this->hasOne(Souscripteur::class,'user_id','id')->withTrashed();
    }
    public function medecinControle(){
        return $this->hasOne(MedecinControle::class,'user_id','id')->withTrashed();
    }
    public function assistante(){
        return $this->hasOne(Assistante::class,'user_id','id')->withTrashed();
    }
    public function pharmacien(){
        return $this->hasOne(Pharmacien::class,'user_id','id');
    }
    public function messages()
    {
        return $this->hasMany(Message::class);
    }
    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new MailResetPasswordNotification($token));
    }

    public function contributeurs(){
        return $this->morphMany(Contributeurs::class,'contributable');
    }

    public function questionSecrete(){
        return $this->hasOne(ReponseSecrete::class,'user_id','id');
    }

    public function getSignatureAttribute(){
        if ($this->getFirstMedia('signature')) {
            $arrayLinks = explode("public/", $this->getFirstMedia('signature')->getPath());
            $link = Storage::url($arrayLinks[count($arrayLinks) - 1]);
          } else {
            return null;
          }
          $this->makeHidden('media');
          return asset($link);
    }
    public function rendezVous()
    {
        return $this->hasMany(RendezVous::class, 'patient_id','id');
    }
    public function patients(){
        return $this->belongsToMany(Patient::class, 'patient_medecin_controles', 'patient_id', 'medecin_control_id');
    }

    public function dossier(){
        return $this->hasOne(DossierMedical::class, 'patient_id', 'id');
    }

    public function medecinAvis(){
        return $this->hasMany(MedecinAvis::class, 'medecin_id');
    }
}
