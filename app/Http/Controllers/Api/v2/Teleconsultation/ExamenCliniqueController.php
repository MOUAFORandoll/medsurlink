<?php

namespace App\Http\Controllers\Api\v2\Teleconsultation;

use App\Http\Controllers\Controller;
use App\Services\ExamenCliniqueService;
use Illuminate\Http\Request;

class ExamenCliniqueController extends Controller
{

    private $examenCliniqueService;

    /**
     * ExamenCliniqueController constructor.
     *
     * @param \App\Services\ExamenCliniqueService $examenCliniqueService
     */
    public function __construct(ExamenCliniqueService $examenCliniqueService)
    {
        $this->examenCliniqueService = $examenCliniqueService;
    }

    /**
     * @return mixed
     */
    public function index(Request $request)
    {
        return $this->successResponse($this->examenCliniqueService->fetchExamenCliniques($request));
    }

    /**
     * @param $examen_clinique
     *
     * @return mixed
     */
    public function show($examen_clinique)
    {
        return $this->successResponse($this->examenCliniqueService->fetchExamenClinique($examen_clinique));
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     */
    public function store(Request $request)
    {
        return $this->successResponse($this->examenCliniqueService->createExamenClinique($request->all()));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param                          $examen_clinique
     *
     * @return mixed
     */
    public function update(Request $request, $examen_clinique)
    {
        return $this->successResponse($this->examenCliniqueService->updateExamenClinique($examen_clinique, $request->all()));
    }

    /**
     * @param $examen_clinique
     *
     * @return mixed
     */
    public function destroy($examen_clinique)
    {
        return $this->successResponse($this->examenCliniqueService->deleteExamenClinique($examen_clinique));
    }
}
