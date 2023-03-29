<?php

namespace App\Http\Controllers\Api\v2\Teleconsultation;

use App\Http\Controllers\Controller;
use App\Services\ExamenPertinentPrecedentService;
use Illuminate\Http\Request;

class ExamenPertinentPrecedentController extends Controller
{

    private $examenPertinent;

    /**
     * ExamenPertinentPrecedentController constructor.
     *
     * @param \App\Services\ExamenPertinentPrecedentService $examenPertinent
     */
    public function __construct(ExamenPertinentPrecedentService $examenPertinent)
    {
        $this->examenPertinent = $examenPertinent;
    }

    /**
     * @return mixed
     */
    public function index(Request $request)
    {
        return $this->successResponse($this->examenPertinent->fetchExamenPertinents($request));
    }

    /**
     * @param $examen_pertinent
     *
     * @return mixed
     */
    public function show($examen_pertinent)
    {
        return $this->successResponse($this->examenPertinent->fetchExamenPertinent($examen_pertinent));
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     */
    public function store(Request $request)
    {
        return $this->successResponse($this->examenPertinent->createExamenPertinent($request->all()));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param                          $examen_pertinent
     *
     * @return mixed
     */
    public function update(Request $request, $examen_pertinent)
    {
        return $this->successResponse($this->examenPertinent->updateExamenPertinent($examen_pertinent, $request->all()));
    }

    /**
     * @param $examen_pertinent
     *
     * @return mixed
     */
    public function destroy($examen_pertinent)
    {
        return $this->successResponse($this->examenPertinent->deleteExamenPertinent($examen_pertinent));
    }
}
