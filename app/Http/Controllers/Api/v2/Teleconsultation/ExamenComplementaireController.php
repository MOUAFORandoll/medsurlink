<?php

namespace App\Http\Controllers\Api\v2\Teleconsultation;

use App\Http\Controllers\Controller;
use App\Services\ExamenComplementaireService;
use Illuminate\Http\Request;

class ExamenComplementaireController extends Controller
{

    private $examenComplementaire;

    /**
     * ExamenComplementaireController constructor.
     *
     * @param \App\Services\ExamenComplementaireService $examenComplementaire
     */
    public function __construct(ExamenComplementaireService $examenComplementaire)
    {
        $this->examenComplementaire = $examenComplementaire;
    }

    /**
     * @return mixed
     */
    public function index(Request $request)
    {
        return $this->successResponse($this->examenComplementaire->fetchExamenComplementaires($request));
    }

    /**
     * @param $examen_complementaire
     *
     * @return mixed
     */
    public function show($examen_complementaire)
    {
        return $this->successResponse($this->examenComplementaire->fetchExamenComplementaire($examen_complementaire));
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     */
    public function store(Request $request)
    {
        return $this->successResponse($this->examenComplementaire->createExamenComplementaire($request->all()));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param                          $examen_complementaire
     *
     * @return mixed
     */
    public function update(Request $request, $examen_complementaire)
    {
        return $this->successResponse($this->examenComplementaire->updateExamenComplementaire($examen_complementaire, $request->all()));
    }

    /**
     * @param $examen_complementaire
     *
     * @return mixed
     */
    public function destroy($examen_complementaire)
    {
        return $this->successResponse($this->examenComplementaire->deleteExamenComplementaire($examen_complementaire));
    }
}
