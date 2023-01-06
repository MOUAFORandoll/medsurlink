<?php

namespace App\Http\Controllers\Api\v2\Teleconsultation;

use App\Http\Controllers\Controller;
use App\Services\AllergieService;
use Illuminate\Http\Request;

class AllergieController extends Controller
{

    private $allergieService;

    /**
     * AllergieController constructor.
     *
     * @param \App\Services\AllergieService $allergieService
     */
    public function __construct(AllergieService $allergieService)
    {
        $this->allergieService = $allergieService;
    }

    /**
     * @return mixed
     */
    public function index(Request $request)
    {
        return $this->successResponse($this->allergieService->fetchAllergies($request));
    }

    /**
     * @param $allergie
     *
     * @return mixed
     */
    public function show($allergie)
    {
        return $this->successResponse($this->allergieService->fetchAllergie($allergie));
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     */
    public function store(Request $request)
    {
        return $this->successResponse($this->allergieService->createAllergie($request->all()));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param                          $allergie
     *
     * @return mixed
     */
    public function update(Request $request, $allergie)
    {
        return $this->successResponse($this->allergieService->updateAllergie($allergie, $request->all()));
    }

    /**
     * @param $allergie
     *
     * @return mixed
     */
    public function destroy($relation_id, $allergie, $relation)
    {
        return $this->successResponse($this->allergieService->deleteAllergie($relation_id, $allergie, $relation));
    }
}
