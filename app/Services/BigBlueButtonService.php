<?php

namespace App\Services;

use App\Models\Metting;
use App\Traits\RequestService;
use App\User;
use Illuminate\Http\Request;


use BigBlueButton\BigBlueButton;
use BigBlueButton\Parameters\CreateMeetingParameters;
use BigBlueButton\Parameters\JoinMeetingParameters;
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
            $joinMeetingParams = new JoinMeetingParameters($metting->id, $this->user->name, config('app.bigbluebuttom_pass'));
            $joinMeetingParams->setRedirect(true);
            $url = $bbb->getJoinMeetingURL($joinMeetingParams);
            return $url;
        }else{
            $name = "Téléconsultation de {$patient->name} par  {$this->user->name}";
            $metting = Metting::create(['uuid' => Str::uuid(), 'patient_id' => $user_id, 'medecin_id' => $this->user->id, 'name' => $name]);
            return $this->stroreMetting($metting->id, $metting->name);
        }

    }

    public function stroreMetting($metting_id, $name){
        $bbb = new BigBlueButton();
        $createParams = new CreateMeetingParameters($metting_id, $name);
        $createParams = $createParams->setModeratorPassword(config('app.bigbluebuttom_pass'))->setAttendeePassword(config('app.bigbluebuttom_pass'));
        $createParams->setRecord(true);
        $createParams->setAllowStartStopRecording(true);
        $createParams->setLogoutUrl($this->url_global."/teleconsultations/create");


        $response = $bbb->createMeeting($createParams);
        if($response->getReturnCode() == 'FAILED') {
            return 'Can\'t create room! please contact our administrator.';
        }else {
            $joinMeetingParams = new JoinMeetingParameters($metting_id, $this->user->name, config('app.bigbluebuttom_pass'));
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
        $joinMeetingParams = new JoinMeetingParameters($metting->id, $patient->name, config('app.bigbluebuttom_pass'));
        $joinMeetingParams->setRedirect(true);
        $url = $bbb->getJoinMeetingURL($joinMeetingParams);
        return $url;
    }


}
