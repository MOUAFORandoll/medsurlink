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
     * @param $bon_prise_en_charge
     *
     * @return mixed
     */
    public function show($bon_prise_en_charge)
    {
        return $this->successResponse($this->bonPriseEnChargeService->fetchBonPriseEnCharge($bon_prise_en_charge));
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
     * @param                          $bon_prise_en_charge
     *
     * @return mixed
     */
    public function update(Request $request, $bon_prise_en_charge)
    {
        return $this->successResponse($this->bonPriseEnChargeService->updateBonPriseEnCharge($bon_prise_en_charge, $request->all()));
    }

    /**
     * @param $bon_prise_en_charge
     *
     * @return mixed
     */
    public function destroy($bon_prise_en_charge)
    {
        return $this->successResponse($this->bonPriseEnChargeService->deleteBonPriseEnCharge($bon_prise_en_charge));
    }
}
