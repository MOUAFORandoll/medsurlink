<?php

namespace App\Http\Controllers\Api\v2\Teleconsultation;

use App\Http\Controllers\Controller;
use App\Services\BonpriseEnChargeService;
use Illuminate\Http\Request;

class BonPriseEnChargeController extends Controller
{

    private $bonPriseEnChargeService;

    /**
     *
     * @param \App\Services\BonpriseEnChargeService $bonPriseEnChargeService
     */
    public function __construct(BonpriseEnChargeService $bonPriseEnChargeService)
    {
        $this->bonPriseEnChargeService = $bonPriseEnChargeService;
    }

    /**
     * @return mixed
     */
    public function index(Request $request)
    {
        return $this->successResponse($this->bonPriseEnChargeService->fetchBonPriseEnCharges($request));
    }

    /**
     * @param $examenAnalyse
     *
     * @return mixed
     */
    public function show($examenAnalyse)
    {
        return $this->successResponse($this->bonPriseEnChargeService->fetchBonPriseEnCharge($examenAnalyse));
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     */
    public function store(Request $request)
    {
        return $this->successResponse($this->bonPriseEnChargeService->createBonPriseEnCharge($request->all()));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param                          $examenAnalyse
     *
     * @return mixed
     */
    public function update(Request $request, $examenAnalyse)
    {
        return $this->successResponse($this->bonPriseEnChargeService->updateBonPriseEnCharge($examenAnalyse, $request->all()));
    }

    /**
     * @param $examenAnalyse
     *
     * @return mixed
     */
    public function destroy($examenAnalyse)
    {
        return $this->successResponse($this->bonPriseEnChargeService->deleteBonPriseEnCharge($examenAnalyse));
    }
}
