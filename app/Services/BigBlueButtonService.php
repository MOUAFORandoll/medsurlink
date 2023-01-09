<?php

namespace App\Services;

use App\Traits\RequestService;
use App\User;
use Illuminate\Http\Request;


use BigBlueButton\BigBlueButton;
use BigBlueButton\Parameters\CreateMeetingParameters;
use BigBlueButton\Parameters\JoinMeetingParameters;

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
        $patient = User::find($user_id);
        $bbb = new BigBlueButton();
        $createParams = new CreateMeetingParameters("meetingId", "Téléconsultation de {$patient->name} par Dr {$this->user->name}");
        $createParams = $createParams->setModeratorPassword("9UqG@CQAE6dfB")->setAttendeePassword("9UqG@CQAE6dfB");
        $createParams->setRecord(true);
        $createParams->setAllowStartStopRecording(true);
        $createParams->setLogoutUrl($this->url_global."/teleconsultations/create");

        $response = $bbb->createMeeting($createParams);
        if($response->getReturnCode() == 'FAILED') {
            return 'Can\'t create room! please contact our administrator.';
        }else {
            $joinMeetingParams = new JoinMeetingParameters("meetingId", $this->user->name, "9UqG@CQAE6dfB");
            $joinMeetingParams->setRedirect(true);
            $url = $bbb->getJoinMeetingURL($joinMeetingParams);
            return $url;
        }
    }

    public function joinMetting($user_id)
    {
        $patient = User::find($user_id);
        $bbb = new BigBlueButton();
        $joinMeetingParams = new JoinMeetingParameters("meetingId", $patient->name, "9UqG@CQAE6dfB");
        $joinMeetingParams->setRedirect(true);
        $url = $bbb->getJoinMeetingURL($joinMeetingParams);
        return $url;
    }


}
