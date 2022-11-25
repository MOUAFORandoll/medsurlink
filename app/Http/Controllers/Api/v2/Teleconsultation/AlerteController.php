<?php

namespace App\Http\Controllers\Api\v2\Teleconsultation;

use App\Http\Controllers\Controller;
use App\Services\AlerteService;
use Illuminate\Http\Request;

class AlerteController extends Controller
{

    private $alerteService;

    /**
     * AllergieController constructor.
     *
     * @param \App\Services\AlerteService $alerteService
     */
    public function __construct(AlerteService $alerteService)
    {
        $this->alerteService = $alerteService;
    }

    /**
     * @return mixed
     */
    public function index(Request $request)
    {
        return $this->successResponse($this->alerteService->index($request));
    }

    /**
     * @param $allergie
     *
     * @return mixed
     */
    public function show($allergie)
    {
        return $this->successResponse($this->alerteService->show($allergie));
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
     * @param                          $allergie
     *
     * @return mixed
     */
    public function update(Request $request, $allergie)
    {
        $this->validate($request, $this->validations(true));
        return $this->successResponse($this->alerteService->update($allergie, $request));
    }

    /**
     * @param $allergie
     *
     * @return mixed
     */
    public function destroy($allergie)
    {
        return $this->successResponse($this->alerteService->destroy($allergie));
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
