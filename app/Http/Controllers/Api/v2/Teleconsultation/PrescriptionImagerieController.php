<?php

namespace App\Http\Controllers\Api\v2\Teleconsultation;

use App\Http\Controllers\Controller;
use App\Services\PrescriptionImagerieService;
use Illuminate\Http\Request;

class PrescriptionImagerieController extends Controller
{

    private $prescriptionImagerieService;

    /**
     *
     * @param \App\Services\PrescriptionImagerieService $prescriptionImagerieService
     */
    public function __construct(PrescriptionImagerieService $prescriptionImagerieService)
    {
        $this->prescriptionImagerieService = $prescriptionImagerieService;
    }

    /**
     * @return mixed
     */
    public function index(Request $request)
    {
        return $this->successResponse($this->prescriptionImagerieService->fetchPrescriptionImageries($request));
    }

    /**
     * @param $examenAnalyse
     *
     * @return mixed
     */
    public function show($examenAnalyse)
    {
        return $this->successResponse($this->prescriptionImagerieService->fetchPrescriptionImagerie($examenAnalyse));
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     */
    public function store(Request $request)
    {
        return $this->successResponse($this->prescriptionImagerieService->createPrescriptionImagerie($request->all()));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param                          $examenAnalyse
     *
     * @return mixed
     */
    public function update(Request $request, $examenAnalyse)
    {
        return $this->successResponse($this->prescriptionImagerieService->updatePrescriptionImagerie($examenAnalyse, $request->all()));
    }

    /**
     * @param $examenAnalyse
     *
     * @return mixed
     */
    public function destroy($examenAnalyse)
    {
        return $this->successResponse($this->prescriptionImagerieService->deletePrescriptionImagerie($examenAnalyse));
    }
}
