<?php

namespace App\Http\Controllers\Api\v2\Teleconsultation;

use App\Http\Controllers\Controller;
use App\Services\ExamenAnalyseService;
use Illuminate\Http\Request;

class ExamenAnalyseController extends Controller
{

    private $examenAnalyseService;

    /**
     * 
     *
     * @param \App\Services\ExamenAnalyseService $examenAnalyseService
     */
    public function __construct(ExamenAnalyseService $examenAnalyseService)
    {
        $this->examenAnalyseService = $examenAnalyseService;
    }

    /**
     * @return mixed
     */
    public function index(Request $request)
    {
        return $this->successResponse($this->examenAnalyseService->fetchExamenAnalyses($request));
    }

    /**
     * @param $examenAnalyse
     *
     * @return mixed
     */
    public function show($examenAnalyse)
    {
        return $this->successResponse($this->examenAnalyseService->fetchExamenAnalyse($examenAnalyse));
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     */
    public function store(Request $request)
    {
        return $this->successResponse($this->examenAnalyseService->createExamenAnalyse($request->all()));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param                          $examenAnalyse
     *
     * @return mixed
     */
    public function update(Request $request, $examenAnalyse)
    {
        return $this->successResponse($this->examenAnalyseService->updateExamenAnalyse($examenAnalyse, $request->all()));
    }

    /**
     * @param $examenAnalyse
     *
     * @return mixed
     */
    public function destroy($examenAnalyse)
    {
        return $this->successResponse($this->examenAnalyseService->deleteExamenAnalyse($examenAnalyse));
    }
}
