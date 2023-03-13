<?php

namespace App\Http\Controllers\Api\v2\Teleconsultation;

use App\Http\Controllers\Controller;
use App\Services\InformationSupplementaireService;
use Illuminate\Http\Request;

class InformationSupplementaireController extends Controller
{

    private $informationSupplementaire;

    /**
     * ExamenPertinentPrecedentController constructor.
     *
     * @param \App\Services\InformationSupplementaireService $informationSupplementaire
     */
    public function __construct(InformationSupplementaireService $informationSupplementaire)
    {
        $this->informationSupplementaire = $informationSupplementaire;
    }

    /**
     * @return mixed
     */
    public function index(Request $request)
    {
        return $this->successResponse($this->informationSupplementaire->fetchInformationSupplementaires($request));
    }

    /**
     * @param $information_supplementaire
     *
     * @return mixed
     */
    public function show($information_supplementaire)
    {
        return $this->successResponse($this->informationSupplementaire->fetchInformationSupplementaire($information_supplementaire));
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     */
    public function store(Request $request)
    {
        return $this->successResponse($this->informationSupplementaire->createInformationSupplementaire($request->all()));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param                          $information_supplementaire
     *
     * @return mixed
     */
    public function update(Request $request, $information_supplementaire)
    {
        return $this->successResponse($this->informationSupplementaire->updateInformationSupplementaire($information_supplementaire, $request->all()));
    }

    /**
     * @param $information_supplementaire
     *
     * @return mixed
     */
    public function destroy($information_supplementaire)
    {
        return $this->successResponse($this->informationSupplementaire->deleteInformationSupplementaire($information_supplementaire));
    }
}
