<?php

namespace App\Http\Controllers\Api\v2\Teleconsultation;

use App\Http\Controllers\Controller;
use App\Services\EtablissementService;
use Illuminate\Http\Request;

class EtablissementController extends Controller
{

    private $etablissementService;

    /**
     * EtablissementController constructor.
     *
     * @param \App\Services\EtablissementService $etablissementService
     */
    public function __construct(EtablissementService $etablissementService)
    {
        $this->etablissementService = $etablissementService;
    }

    /**
     * @return mixed
     */
    public function index(Request $request)
    {
        return $this->successResponse($this->etablissementService->fetchEtablissements($request));
    }

    /**
     * @param $etablissement
     *
     * @return mixed
     */
    public function show($etablissement)
    {
        return $this->successResponse($this->etablissementService->fetchEtablissement($etablissement));
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     */
    public function store(Request $request)
    {
        return $this->successResponse($this->etablissementService->createEtablissement($request->all()));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param                          $etablissement
     *
     * @return mixed
     */
    public function update(Request $request, $etablissement)
    {
        return $this->successResponse($this->etablissementService->updateEtablissement($etablissement, $request->all()));
    }

    /**
     * @param $etablissement
     *
     * @return mixed
     */
    public function destroy($etablissement)
    {
        return $this->successResponse($this->etablissementService->deleteEtablissement($etablissement));
    }
}
