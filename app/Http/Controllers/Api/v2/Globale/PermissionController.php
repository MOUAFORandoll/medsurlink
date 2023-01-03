<?php

namespace App\Http\Controllers\Api\v2\Globale;

use App\Http\Controllers\Controller;
use App\Services\AlerteService;
use Illuminate\Http\Request;

class PermissionController extends Controller
{

    private $alerteService;

    /**
     * class AlerteController extends Controller
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
        return $this->successResponse($this->alerteService->update($request, $alerte));
    }

    public function assignMedecin(Request $request, $alerte){
        $this->validate($request, [
            'medecin_id' => 'required',
        ]);
        return $this->successResponse($this->alerteService->assignMedecin($request, $alerte));
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
                //'statut_id' => 'required',
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
