<?php

namespace App\Http\Controllers\Api\v2\Teleconsultation;

use App\Http\Controllers\Controller;
use App\Services\PatientService;
use App\Services\TeleconsultationService;
use Illuminate\Http\Request;

class TeleconsultationController extends Controller
{

    private $teleconsultation;

    /**
     * TeleconsultationController constructor.
     *
     * @param \App\Services\TeleconsultationService $teleconsultation
     */
    public function __construct(TeleconsultationService $teleconsultation)
    {
        $this->teleconsultation = $teleconsultation;
    }

    /**
     * @return mixed
     */
    public function index(Request $request)
    {
        return $this->successResponse($this->teleconsultation->fetchTeleconsultations($request));
    }

    /**
     * @param $teleconsultation
     *
     * @return mixed
     */
    public function show($teleconsultation)
    {
        return $this->successResponse($this->teleconsultation->fetchTeleconsultation($teleconsultation));
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     */
    public function store(Request $request)
    {
        return $this->successResponse($this->teleconsultation->createTeleconsultation($request->all()));
    }

    /**
     * Summary of alerte
     * @param mixed $medecin_id
     * @param mixed $patient_id
     * @return mixed
     */
    public function alerte($medecin_id, $patient_id){
        return $this->successResponse($this->teleconsultation->fetchAlerte($medecin_id, $patient_id));
    }

    public function fetchAllergies($patient_id){
        return $this->successResponse($this->teleconsultation->fetchAllergies($patient_id));
    }
    public function fetchAntecedents($patient_id){
        return $this->successResponse($this->teleconsultation->fetchAntecedents($patient_id));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param                          $teleconsultation
     *
     * @return mixed
     */
    public function update(Request $request, $teleconsultation)
    {
        return $this->successResponse($this->teleconsultation->updateTeleconsultation($teleconsultation, $request->all()));
    }

    /**
     * @param $teleconsultation
     *
     * @return mixed
     */
    public function destroy($teleconsultation)
    {
        return $this->successResponse($this->teleconsultation->deleteTeleconsultation($teleconsultation));
    }
}
