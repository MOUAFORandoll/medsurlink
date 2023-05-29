<?php

namespace App\Http\Controllers\Api\v2\Alerte;

use App\Http\Controllers\Controller;
use App\Services\Alerte\SpecialiteService;
use Illuminate\Http\Request;

class SpecialiteController extends Controller
{

    private $specialiteService;

    /**
     * SpecialiteController constructor.
     *
     * @param \App\Services\Alerte\SpecialiteService $specialiteService
     */
    public function __construct(SpecialiteService $specialiteService)
    {
        $this->specialiteService = $specialiteService;
    }

    /**
     * @return mixed
     */
    public function index(Request $request)
    {
        return $this->successResponse($this->specialiteService->fetchSpecialites($request));
    }

    /**
     * @param $niveau_urgence
     *
     * @return mixed
     */
    public function show($niveau_urgence)
    {
        return $this->successResponse($this->specialiteService->fetchSpecialite($niveau_urgence));
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     */
    public function store(Request $request)
    {
        return $this->successResponse($this->specialiteService->createSpecialite($request->all()));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param                          $niveau_urgence
     *
     * @return mixed
     */
    public function update(Request $request, $niveau_urgence)
    {
        return $this->successResponse($this->specialiteService->updateSpecialite($niveau_urgence, $request->all()));
    }

    /**
     * @param $niveau_urgence
     *
     * @return mixed
     */
    public function destroy($niveau_urgence)
    {
        return $this->successResponse($this->specialiteService->deleteSpecialite($niveau_urgence));
    }
}
