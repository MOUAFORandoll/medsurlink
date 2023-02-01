<?php

namespace App\Models;

use Antonrom\ModelChangesHistory\Traits\HasChangesHistory;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class Alerte extends Model implements HasMedia
{
    use Notifiable, HasMediaTrait, HasChangesHistory, SoftDeletes;


    protected $table = 'alertes';

    protected $fillable = ['uuid', 'patient_id', 'medecin_id', 'niveau_urgence_id', 'teleconsultation_id', 'statut_id', 'creator_id', 'plainte'];

    protected $appends = ['audio', 'audio1'];

    protected $slackChannels= [
        'test' => 'https://hooks.slack.com/services/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',
        'teleconsultation' => 'https://hooks.slack.com/services/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'
    ];

    protected $slack_url = null;

    public function patient(){
        return $this->belongsTo(User::class);
    }


    public function creator(){
        return $this->belongsTo(User::class);
    }
    public function medecin(){
        return $this->belongsTo(User::class);
    }

    public function routeNotificationForSlack(){
        $env = strtolower(config('app.env'));
        if ($env == 'production')
            return $this->slackChannels["teleconsultation"];
        else
            return $this->slackChannels["test"];
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

    public function getSlackChannel(){
        $env = strtolower(config('app.env'));
        if ($env == 'production')
            return $this->setSlackUrl($this->slackChannels["teleconsultation"]);
        else
            return $this->setSlackUrl($this->slackChannels["test"]);
    }

    /**
     * @param $url
     * @return $this
     */
    public function setSlackUrl($url){
        $this->slack_url = $url;

        return $this;
    }

    public function getAudioAttribute(){
        if ($this->getFirstMedia('audio')) {
            $arrayLinks = explode("public/", $this->getFirstMedia('audio')->getPath());
            $link = Storage::url($arrayLinks[count($arrayLinks) - 1]);
        } else {
            return null;
        }
        $this->makeHidden('media');
        return asset($link);
    }

    public function getAudio1Attribute(){
        if ($this->getFirstMedia('audio1')) {
            $arrayLinks = explode("public/", $this->getFirstMedia('audio1')->getPath());
            $link = Storage::url($arrayLinks[count($arrayLinks) - 1]);
        } else {
            return null;
        }
        $this->makeHidden('media');
        return asset($link);
    }

}
