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
