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
use BigBlueButton\Parameters\GetRecordingsParameters;
use BigBlueButton\Parameters\IsMeetingRunningParameters;
use Carbon\Carbon;
use Exception;
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
        try {
            $bbb = new BigBlueButton();
            $createParams = new CreateMeetingParameters($metting_id, $name);
            $createParams = $createParams->setModeratorPassword(config('app.password.moderator'))->setAttendeePassword(config('app.password.attendee'));
            $createParams->setRecord(true);
            $createParams->setAllowStartStopRecording(true);
            $createParams->setLogoutUrl($this->url_global."/teleconsultations");
            $response = $bbb->createMeeting($createParams);
            if($response->getReturnCode() == 'FAILED') {
                \Log::alert("create ", [$response->getReturnCode()]);
                return "";
            }else {
                $joinMeetingParams = new JoinMeetingParameters($metting_id, $this->user->name, config('app.password.moderator'));
                $joinMeetingParams->setRedirect(true);
                $url = $bbb->getJoinMeetingURL($joinMeetingParams);
                return $url;
            }
        } catch (Exception $ex) {
            \Log::alert("stroreMetting ", [$ex->getMessage()]);
            return "";
        }
    }

    public function joinMetting($user_id)
    {
        try {
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
        } catch (Exception $ex) {
            \Log::alert("joinMetting ", [$ex->getMessage()]);
            return "";
        }

    }

    public function endMeetingParameters($bbb, $meetingID){
        try{
            $endMeetingParams = new EndMeetingParameters($meetingID, config('app.password.moderator'));
            $response = $bbb->endMeeting($endMeetingParams);
        }
        catch(Exception $ex){
            \Log::alert("endMeetingParameters ", [$ex->getMessage()]);
            return "";
        }
    }

    public function getRecordings($patient_id, $medecin_id, $date_teleconsultation){
        $metting = Metting::where(['patient_id' => $patient_id, 'medecin_id' => $medecin_id, 'statut' => 3])->whereDate('created_at', Carbon::parse($date_teleconsultation)->format('Y-m-d'))->latest()->first();
        if(!is_null($metting)){
            return $metting->url;
        }else{
            $metting = Metting::where(['patient_id' => $patient_id, 'medecin_id' => $medecin_id, 'statut' => 2])->whereDate('created_at', Carbon::parse($date_teleconsultation)->format('Y-m-d'))->latest()->first();

            if(!is_null($metting)){
                if(!is_null($metting->url)){
                    $metting->statut = 3;
                    $metting->save();
                    return $metting->url;
                }else{
                    $recordingParams = new GetRecordingsParameters();
                    $recordingParams->setMeetingId($metting->id);
                    $bbb = new BigBlueButton();
                    try {
                        $response = $bbb->getRecordings($recordingParams);
                        if ($response->getReturnCode() == 'SUCCESS') {
                            $metting->url = isset($response->getRawXml()->recordings->recording->playback) ? $response->getRawXml()->recordings->recording->playback->format->url : null;
                            $metting->statut = 3;
                            $metting->save();
                            return $metting->url;
                        }
                    }catch (Exception $ex) {
                        \Log::alert("getRecordings ", [$ex->getMessage()]);
                        return "";
                    }
                }
            }
        }
        return "";
    }

}
