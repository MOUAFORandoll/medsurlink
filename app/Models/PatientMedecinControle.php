<?php

namespace App\Models;

use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use App\Notifications\MedecinToPatient;

class PatientMedecinControle extends Model
{
    use SoftDeletes;
    use Sluggable;
    use Notifiable;

    protected $fillable = [
        "creator",
        "medecin_control_id",
        "patient_id",
        "slug",
    ];

    protected $slackChannels= [
        'test' => 'https://hooks.slack.com/services/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',
        'test2' => 'https://hooks.slack.com/services/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',
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
        if($this->slack_url === null){
            return $this->slackChannels['test'];
        }
        return $this->slack_url;
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

    public function patients(){
        return $this->belongsTo(Patient::class,'patient_id','user_id');
    }
    public function medecinControles(){
        return $this->belongsTo(MedecinControle::class,'medecin_control_id','user_id');
    }
}
