<?php

namespace App\Http\Controllers\Api\v2\Teleconsultation;

use App\Http\Controllers\Controller;
use App\Services\RaisonPrescriptionService;
use Illuminate\Http\Request;

class RaisonPrescriptionController extends Controller
{

    private $raison_financement;

    /**
     * RaisonPrescriptionController constructor.
     *
     * @param \App\Services\RaisonPrescriptionService $raison_financement
     */
    public function __construct(RaisonPrescriptionService $raison_financement)
    {
        $this->raison_financement = $raison_financement;
    }

    /**
     * @return mixed
     */
    public function index(Request $request)
    {
        return $this->successResponse($this->raison_financement->fetchRaisonPrescriptions($request));
    }

    /**
     * @param $raison_financement
     *
     * @return mixed
     */
    public function show($raison_financement)
    {
        return $this->successResponse($this->raison_financement->fetchRaisonPrescription($raison_financement));
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     */
    public function store(Request $request)
    {
        return $this->successResponse($this->raison_financement->createRaisonPrescription($request->all()));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param                          $raison_financement
     *
     * @return mixed
     */
    public function update(Request $request, $raison_financement)
    {
        return $this->successResponse($this->raison_financement->updateRaisonPrescription($raison_financement, $request->all()));
    }

    /**
     * @param $raison_financement
     *
     * @return mixed
     */
    public function destroy($raison_financement)
    {
        return $this->successResponse($this->raison_financement->deleteRaisonPrescription($raison_financement));
    }
}
