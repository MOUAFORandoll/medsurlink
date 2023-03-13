<?php

namespace App\Models;

use Antonrom\ModelChangesHistory\Traits\HasChangesHistory;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use App\Notifications\MedecinToPatient;
use App\User;

/**
 * App\Models\PatientMedecinControle
 *
 * @property int $id
 * @property int $medecin_control_id
 * @property int $patient_id
 * @property int|null $creator
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read User|null $createur
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\DelaiOperation[] $delai_operations
 * @property-read int|null $delai_operations_count
 * @property-read mixed $consultation_and_timestamp
 * @property-read \Illuminate\Database\Eloquent\Collection|\Antonrom\ModelChangesHistory\Models\Change[] $historyChangesMorph
 * @property-read int|null $history_changes_morph_count
 * @property-read \Antonrom\ModelChangesHistory\Models\Change|null $latestChangeMorph
 * @property-read \App\Models\MedecinControle $medecinControles
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \App\Models\Patient $patients
 * @method static \Illuminate\Database\Eloquent\Builder|PatientMedecinControle findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|PatientMedecinControle newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PatientMedecinControle newQuery()
 * @method static \Illuminate\Database\Query\Builder|PatientMedecinControle onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|PatientMedecinControle query()
 * @method static \Illuminate\Database\Eloquent\Builder|PatientMedecinControle whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PatientMedecinControle whereCreator($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PatientMedecinControle whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PatientMedecinControle whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PatientMedecinControle whereMedecinControlId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PatientMedecinControle wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PatientMedecinControle whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PatientMedecinControle whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|PatientMedecinControle withTrashed()
 * @method static \Illuminate\Database\Query\Builder|PatientMedecinControle withoutTrashed()
 * @mixin \Eloquent
 */
class PatientMedecinControle extends Model
{
    use SoftDeletes;
    use Sluggable;
    use Notifiable;
    use HasChangesHistory;

    protected $fillable = [
        "creator",
        "medecin_control_id",
        "patient_id",
        "slug",
    ];

    protected $slackChannels= [
        'test' => 'https://hooks.slack.com/services/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',
        'affilie' => 'https://hooks.slack.com/services/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',
        'appel' => 'https://hooks.slack.com/services/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'
    ];
    protected $slack_url = null;

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'ConsultationAndTimestamp'
            ]
        ];
    }
    public function getConsultationAndTimestampAttribute() {
        return str_random(6). ' ' .Carbon::now()->timestamp;
    }

    public function scopeMedRefSemaineMoisAnnee($query, $intervalle_debut, $intervalle_fin)
    {
        return $query->where(function ($query) use($intervalle_debut, $intervalle_fin) {
            $query->whereDate('created_at', '>=', $intervalle_debut)->whereDate('created_at', '<=', $intervalle_fin);
        })->orderBy('created_at', 'asc');
    }

    /**
     * Send the affectation notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendAffectationNotification($token)
    {
        $this->notify(new MedecinToPatient($token));
    }

    public function routeNotificationForSlack(){
        $env = strtolower(config('app.env'));
        if ($env == 'production')
            return $this->slackChannels["appel"];
        else
            return $this->slackChannels["appel"];
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

    public function getAffilieSlackChannel($affilie = "affilie"){
        $env = strtolower(config('app.env'));
        if ($env == 'production')
            return $this->setSlackUrl($this->slackChannels[$affilie]);
        else
            return $this->setSlackUrl($this->slackChannels["affilie"]);
    }

    public function getAppelSlackChannel($appel = "appel"){
        $env = strtolower(config('app.env'));
        if ($env == 'production')
            return $this->setSlackUrl($this->slackChannels[$appel]);
        else
            return $this->setSlackUrl($this->slackChannels["appel"]);
    }


    /**
     * @param $url
     * @return $this
     */
    public function setSlackUrl($url){
        $this->slack_url = $url;

        return $this;
    }
    public function createur(){
        return $this->belongsTo(User::class,'creator','id');
    }
    public function patients(){
        return $this->belongsTo(Patient::class,'patient_id','user_id');
    }

    public function affiliations(){
        return $this->hasMany(Affiliation::class);
    }
    public function medecinControles(){
        return $this->belongsTo(MedecinControle::class,'medecin_control_id','user_id');
    }

    public function delai_operations()
    {
        return $this->morphMany(DelaiOperation::class, 'delai_operationable');
    }
}

