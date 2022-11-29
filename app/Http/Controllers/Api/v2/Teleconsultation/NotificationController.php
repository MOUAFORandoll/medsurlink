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


    public function readAll()
    {
        $user = \Auth::guard('api')->user();
        $user->unreadNotifications()->update(['read_at' => now()]);
        return $this->successResponse([]);
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     */
    public function markAsRead($notification)
    {
        $user = \Auth::guard('api')->user();
        $user->unreadNotifications()->where('id', $notification)->update(['read_at' => now()]);
        return $this->successResponse($notification);
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
