<?php

namespace App\Http\Controllers\Api\v2\Teleconsultation;

use App\Http\Controllers\Controller;
use App\Services\AlerteService;
use Illuminate\Http\Request;

class NotificationController extends Controller
{

    /**
     * @return mixed
     */
    public function index(Request $request)
    {
        $user = \Auth::guard('api')->user();

        $user->unread_notifications = $user->unreadNotifications()->latest()->get();
        $user->unread_notifications = $user->unreadNotifications->makeHidden(['updated_at', 'pivot', 'guard_name', 'notifiable_type', 'read_at']);
        return $this->successResponse($user->unread_notifications);
    }

    /**
     * @param $alerte
     *
     * @return mixed
     */
    public function show($alerte)
    {
        return $this->successResponse($this->alerteService->show($alerte));
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     */
    public function store(Request $request)
    {
        $this->validate($request, $this->validations());
        return $this->successResponse($this->alerteService->store($request));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param                          $alerte
     *
     * @return mixed
     */
    public function update(Request $request, $alerte)
    {
        $this->validate($request, $this->validations(true));
        return $this->successResponse($this->alerteService->update($alerte, $request));
    }

    /**
     * @param $alerte
     *
     * @return mixed
     */
    public function destroy($alerte)
    {
        return $this->successResponse($this->alerteService->destroy($alerte));
    }

    public function validations($is_update = false){
        if($is_update){
            $rules = [
                'patient_id' => 'required',
                'niveau_urgence_id' => 'required',
                'statut_id' => 'required',
                'plainte' => 'required'
            ];
        }else{
            $rules = [
                'patient_id' => 'required',
                'niveau_urgence_id' => 'required',
                'plainte' => 'required'
            ];
        }
        return $rules;
    }
}
