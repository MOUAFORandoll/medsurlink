<?php

namespace App\Services;

use App\Models\Metting;
use App\Traits\RequestService;
use App\User;
use Illuminate\Http\Request;


use BigBlueButton\BigBlueButton;
use BigBlueButton\Parameters\CreateMeetingParameters;
use BigBlueButton\Parameters\JoinMeetingParameters;
use BigBlueButton\Parameters\EndMeetingParameters;
use BigBlueButton\Parameters\IsMeetingRunningParameters;
use Illuminate\Support\Str;

class BigBlueButtonService
{
    protected $url_global = "", $user = "";
    public function __construct()
    {
        $this->user = \Auth::guard('api')->user();
        $env = strtolower(config('app.env'));
        $this->url_global = "";
        if ($env == 'local')
            $this->url_global = config('app.teleconsultation_loccale');
        else if ($env == 'staging')
            $this->url_global = config('app.teleconsultation_stagging');
        else
            $this->url_global = config('app.teleconsultation_prod');
        $this->url_global = $this->url_global;
    }

    public function createMetting($user_id)
    {
        $metting = Metting::where(['patient_id' => $user_id, 'medecin_id' => $this->user->id])->latest()->first();
        $patient = User::find($user_id);
        if(!is_null($metting)){
            $bbb = new BigBlueButton();
            $this->endMeetingParameters($bbb, $metting->id);
            $name = "Téléconsultation de {$patient->name} par  {$this->user->name}";
            $metting = Metting::create(['uuid' => Str::uuid(), 'patient_id' => $user_id, 'medecin_id' => $this->user->id, 'name' => $name]);
            return $this->stroreMetting($metting->id, $metting->name);
        }else{
            $name = "Téléconsultation de {$patient->name} par  {$this->user->name}";
            $metting = Metting::create(['uuid' => Str::uuid(), 'patient_id' => $user_id, 'medecin_id' => $this->user->id, 'name' => $name]);
            return $this->stroreMetting($metting->id, $metting->name);
        }

    }

    public function stroreMetting($metting_id, $name){
        $bbb = new BigBlueButton();
        $createParams = new CreateMeetingParameters($metting_id, $name);
        $createParams = $createParams
                        ->setModeratorPassword(config('app.password.moderator'))
                        ->setAttendeePassword(config('app.password.attendee'));
        $createParams->setRecord(true);
        $createParams->setAllowStartStopRecording(true);
        $createParams->setLogoutUrl($this->url_global."/teleconsultations");


        $response = $bbb->createMeeting($createParams);
        if($response->getReturnCode() == 'FAILED') {
            return 'Can\'t create room! please contact our administrator.';
        }else {
            $joinMeetingParams = new JoinMeetingParameters($metting_id, $this->user->name, config('app.password.moderator'));
            $joinMeetingParams->setRedirect(true);
            $url = $bbb->getJoinMeetingURL($joinMeetingParams);
            return $url;
        }
    }

    public function joinMetting($user_id)
    {
        $metting = Metting::where(['patient_id' => $user_id, 'medecin_id' => $this->user->id])->latest()->first();
        $patient = User::find($user_id);
        $bbb = new BigBlueButton();
        $joinMeetingParams = new JoinMeetingParameters($metting->id, $patient->name, config('app.password.attendee'));
        $joinMeetingParams->setRedirect(true);

        $shortener = app('url.shortener');

        $url = $shortener->shorten($bbb->getJoinMeetingURL($joinMeetingParams));
        if($patient->telephone){
            sendSMS($patient->telephone, "Hello {$patient->name}, accedez a votre teleconsultation via le lien suivant:\n {$url}");
        }

        return $url;
    }

    public function endMeetingParameters($bbb, $meetingID){
        $endMeetingParams = new EndMeetingParameters($meetingID, config('app.password.moderator'));
        $response = $bbb->endMeeting($endMeetingParams);
    }



}
