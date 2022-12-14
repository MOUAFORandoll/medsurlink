<?php

namespace App\Http\Controllers\Api\v2\Teleconsultation;

use App\Http\Controllers\Controller;
use App\Services\StatutService;
use Illuminate\Http\Request;

class StatutController extends Controller
{

    private $statut;

    /**
     * StatutController constructor.
     *
     * @param \App\Services\StatutService $statut
     */
    public function __construct(StatutService $statut)
    {
        $this->statut = $statut;
    }

    /**
     * @return mixed
     */
    public function index(Request $request)
    {
        return $this->successResponse($this->statut->fetchStatuts($request));
    }

    /**
     * @param $statut
     *
     * @return mixed
     */
    public function show($statut)
    {
        return $this->successResponse($this->statut->fetchStatut($statut));
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     */
    public function store(Request $request)
    {
        return $this->successResponse($this->statut->createStatut($request->all()));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param                          $statut
     *
     * @return mixed
     */
    public function update(Request $request, $statut)
    {
        return $this->successResponse($this->statut->updateStatut($statut, $request->all()));
    }

    /**
     * @param $statut
     *
     * @return mixed
     */
    public function destroy($statut)
    {
        return $this->successResponse($this->statut->deleteStatut($statut));
    }
}
