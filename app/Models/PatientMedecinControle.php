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

    public function routeNotificationForSlack($notification)
    {
       // return "https://hooks.slack.com/services/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";
       return "https://hooks.slack.com/services/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";
    }

    public function patients(){
        return $this->belongsTo(Patient::class,'patient_id','user_id');
    }
    public function medecinControles(){
        return $this->belongsTo(MedecinControle::class,'medecin_control_id','user_id');
    }
}
