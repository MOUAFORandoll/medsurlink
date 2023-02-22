<?php

namespace App\Models;

use Antonrom\ModelChangesHistory\Traits\HasChangesHistory;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

class Metting extends Model
{
    use Notifiable, HasChangesHistory, SoftDeletes;


    protected $table = 'mettings';

    protected $fillable = ['uuid', 'patient_id', 'medecin_id', 'url', 'statut', 'name'];

    // statut 2 encours, 3 terminer


    protected $slackChannels= [
        //'appel' => 'https://hooks.slack.com/services/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',
        'appel' => 'https://hooks.slack.com/services/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'
    ];

    protected $slack_url = null;

    public function patient(){
        return $this->belongsTo(User::class);
    }
    public function medecin(){
        return $this->belongsTo(User::class);
    }

    public function routeNotificationForSlack(){
        $env = strtolower(config('app.env'));
        if ($env == 'production')
            return $this->slackChannels["appel"];
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

    /**
     * @param $url
     * @return $this
     */
    public function setSlackUrl($url){
        $this->slack_url = $url;

        return $this;
    }


}
