<?php

namespace App\Http\Controllers\Api\v2\Teleconsultation;

use App\Http\Controllers\Controller;
use App\Services\NiveauUrgenceService;
use Illuminate\Http\Request;

class NiveauUrgenceController extends Controller
{

    private $niveauUrgence;

    /**
     * NiveauUrgenceController constructor.
     *
     * @param \App\Services\NiveauUrgenceService $niveauUrgence
     */
    public function __construct(NiveauUrgenceService $niveauUrgence)
    {
        $this->niveauUrgence = $niveauUrgence;
    }

    /**
     * @return mixed
     */
    public function index(Request $request)
    {
        return $this->successResponse($this->niveauUrgence->fetchNiveauUrgences($request));
    }

    /**
     * @param $niveau_urgence
     *
     * @return mixed
     */
    public function show($niveau_urgence)
    {
        return $this->successResponse($this->niveauUrgence->fetchNiveauUrgence($niveau_urgence));
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     */
    public function store(Request $request)
    {
        return $this->successResponse($this->niveauUrgence->createNiveauUrgence($request->all()));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param                          $niveau_urgence
     *
     * @return mixed
     */
    public function update(Request $request, $niveau_urgence)
    {
        return $this->successResponse($this->niveauUrgence->updateNiveauUrgence($niveau_urgence, $request->all()));
    }

    /**
     * @param $niveau_urgence
     *
     * @return mixed
     */
    public function destroy($niveau_urgence)
    {
        return $this->successResponse($this->niveauUrgence->deleteNiveauUrgence($niveau_urgence));
    }
}
