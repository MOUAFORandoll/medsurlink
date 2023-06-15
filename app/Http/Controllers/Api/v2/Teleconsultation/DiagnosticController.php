<?php

namespace App\Http\Controllers\Api\v2\Teleconsultation;

use App\Http\Controllers\Controller;
use App\Services\DiagnosticService;
use Illuminate\Http\Request;

class DiagnosticController extends Controller
{

    private $diagnosticService;

    /**
     * DiagnosticController constructor.
     *
     * @param \App\Services\DiagnosticService $diagnosticService
     */
    public function __construct(DiagnosticService $diagnosticService)
    {
        $this->diagnosticService = $diagnosticService;
    }

    /**
     * @return mixed
     */
    public function index(Request $request)
    {
        return $this->successResponse($this->diagnosticService->fetchDiagnostics($request));
    }

    /**
     * @param $diagnostic
     *
     * @return mixed
     */
    public function show($diagnostic)
    {
        return $this->successResponse($this->diagnosticService->fetchDiagnostic($diagnostic));
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     */
    public function store(Request $request)
    {
        return $this->successResponse($this->diagnosticService->createDiagnostic($request->all()));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param                          $diagnostic
     *
     * @return mixed
     */
    public function update(Request $request, $diagnostic)
    {
        return $this->successResponse($this->diagnosticService->updateDiagnostic($diagnostic, $request->all()));
    }

    /**
     * @param $diagnostic
     *
     * @return mixed
     */
    public function destroy($relation_id, $diagnostic, $relation)
    {
        return $this->successResponse($this->diagnosticService->deleteDiagnostic($relation_id, $diagnostic, $relation));
    }
}
