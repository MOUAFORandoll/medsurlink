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

    protected $fillable = ['uuid', 'patient_id', 'medecin_id', 'niveau_urgence_id', 'statut_id', 'creator_id', 'plainte'];

    protected $appends = ['audio'];

    protected $slackChannels= [
        //'appel' => 'https://hooks.slack.com/services/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',
        'appel' => 'https://hooks.slack.com/services/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'
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
        if($this->slack_url === null){
            return $this->slackChannels['appel'];
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


}
