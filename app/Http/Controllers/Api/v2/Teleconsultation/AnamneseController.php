<?php

namespace App\Http\Controllers\Api\v2\Teleconsultation;

use App\Http\Controllers\Controller;
use App\Services\AnamneseService;
use Illuminate\Http\Request;

class AnamneseController extends Controller
{

    private $anamneseService;

    /**
     * AnamneseController constructor.
     *
     * @param \App\Services\AnamneseService $anamneseService
     */
    public function __construct(AnamneseService $anamneseService)
    {
        $this->anamneseService = $anamneseService;
    }

    /**
     * @return mixed
     */
    public function index(Request $request)
    {
        return $this->successResponse($this->anamneseService->fetchAnamneses($request));
    }

    /**
     * @param $anamnese
     *
     * @return mixed
     */
    public function show($anamnese)
    {
        return $this->successResponse($this->anamneseService->fetchAnamnese($anamnese));
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     */
    public function store(Request $request)
    {
        return $this->successResponse($this->anamneseService->createAnamnese($request->all()));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param                          $anamnese
     *
     * @return mixed
     */
    public function update(Request $request, $anamnese)
    {
        return $this->successResponse($this->anamneseService->updateAnamnese($anamnese, $request->all()));
    }

    /**
     * @param $anamnese
     *
     * @return mixed
     */
    public function destroy($anamnese)
    {
        return $this->successResponse($this->anamneseService->deleteAnamnese($anamnese));
    }
}
