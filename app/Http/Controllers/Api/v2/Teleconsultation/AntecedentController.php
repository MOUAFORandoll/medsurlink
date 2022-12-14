<?php

namespace App\Http\Controllers\Api\v2\Teleconsultation;

use App\Http\Controllers\Controller;
use App\Services\AntecedentService;
use Illuminate\Http\Request;

class AntecedentController extends Controller
{

    private $antecedentService;

    /**
     * AntecedentController constructor.
     *
     * @param \App\Services\AntecedentService $antecedentService
     */
    public function __construct(AntecedentService $antecedentService)
    {
        $this->antecedentService = $antecedentService;
    }

    /**
     * @return mixed
     */
    public function index(Request $request)
    {
        return $this->successResponse($this->antecedentService->fetchAntecedents($request));
    }

    /**
     * @param $antecedent
     *
     * @return mixed
     */
    public function show($antecedent)
    {
        return $this->successResponse($this->antecedentService->fetchAntecedent($antecedent));
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     */
    public function store(Request $request)
    {
        return $this->successResponse($this->antecedentService->createAntecedent($request->all()));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param                          $antecedent
     *
     * @return mixed
     */
    public function update(Request $request, $antecedent)
    {
        return $this->successResponse($this->antecedentService->updateAntecedent($antecedent, $request->all()));
    }

    /**
     * @param $antecedent
     *
     * @return mixed
     */
    public function destroy($antecedent)
    {
        return $this->successResponse($this->antecedentService->deleteAntecedent($antecedent));
    }
}
