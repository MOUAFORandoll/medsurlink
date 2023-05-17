<?php

namespace App\Http\Controllers\Api\v2\Teleconsultation;

use App\Http\Controllers\Controller;
use App\Services\VoieAdministrationService;
use Illuminate\Http\Request;

class VoieAdministrationController extends Controller
{

    private $relation_alimentaire;

    /**
     * VoieAdministrationController constructor.
     *
     * @param \App\Services\VoieAdministrationService $relation_alimentaire
     */
    public function __construct(VoieAdministrationService $relation_alimentaire)
    {
        $this->relation_alimentaire = $relation_alimentaire;
    }

    /**
     * @return mixed
     */
    public function index(Request $request)
    {
        return $this->successResponse($this->relation_alimentaire->fetchVoieAdministrations($request));
    }

    /**
     * @param $relation_alimentaire
     *
     * @return mixed
     */
    public function show($relation_alimentaire)
    {
        return $this->successResponse($this->relation_alimentaire->fetchVoieAdministration($relation_alimentaire));
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     */
    public function store(Request $request)
    {
        return $this->successResponse($this->relation_alimentaire->createVoieAdministration($request->all()));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param                          $relation_alimentaire
     *
     * @return mixed
     */
    public function update(Request $request, $relation_alimentaire)
    {
        return $this->successResponse($this->relation_alimentaire->updateVoieAdministration($relation_alimentaire, $request->all()));
    }

    /**
     * @param $relation_alimentaire
     *
     * @return mixed
     */
    public function destroy($relation_alimentaire)
    {
        return $this->successResponse($this->relation_alimentaire->deleteVoieAdministration($relation_alimentaire));
    }
}
