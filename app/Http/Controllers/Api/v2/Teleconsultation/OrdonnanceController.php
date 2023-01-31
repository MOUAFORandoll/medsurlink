<?php

namespace App\Http\Controllers\Api\v2\Teleconsultation;

use App\Http\Controllers\Controller;
use App\Services\OrdonnanceService;
use Illuminate\Http\Request;

class OrdonnanceController extends Controller
{

    private $ordonnanceService;

    /**
     * OrdonnanceController constructor.
     *
     * @param \App\Services\OrdonnanceService $ordonnanceService
     */
    public function __construct(OrdonnanceService $ordonnanceService)
    {
        $this->ordonnanceService = $ordonnanceService;
    }

    /**
     * @return mixed
     */
    public function index(Request $request)
    {
        return $this->successResponse($this->ordonnanceService->fetchOrdonnances($request));
    }

    /**
     * @param $ordonnance
     *
     * @return mixed
     */
    public function show($ordonnance)
    {
        return $this->successResponse($this->ordonnanceService->fetchOrdonnance($ordonnance));
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     */
    public function store(Request $request)
    {
        return $this->successResponse($this->ordonnanceService->createOrdonnance($request->all()));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param                          $ordonnance
     *
     * @return mixed
     */
    public function update(Request $request, $ordonnance)
    {
        return $this->successResponse($this->ordonnanceService->updateOrdonnance($ordonnance, $request->all()));
    }

    /**
     * @param $ordonnance
     *
     * @return mixed
     */
    public function destroy($relation_id, $ordonnance, $relation)
    {
        return $this->successResponse($this->ordonnanceService->deleteOrdonnance($relation_id, $ordonnance, $relation));
    }
}
