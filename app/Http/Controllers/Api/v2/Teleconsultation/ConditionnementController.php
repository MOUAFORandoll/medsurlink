<?php

namespace App\Http\Controllers\Api\v2\Teleconsultation;

use App\Http\Controllers\Controller;
use App\Services\ConditionnementService;
use Illuminate\Http\Request;

class ConditionnementController extends Controller
{

    private $conditionnement;

    /**
     * ConditionnementController constructor.
     *
     * @param \App\Services\ConditionnementService $conditionnement
     */
    public function __construct(ConditionnementService $conditionnement)
    {
        $this->conditionnement = $conditionnement;
    }

    /**
     * @return mixed
     */
    public function index(Request $request)
    {
        return $this->successResponse($this->conditionnement->fetchConditionnements($request));
    }

    /**
     * @param $conditionnement
     *
     * @return mixed
     */
    public function show($conditionnement)
    {
        return $this->successResponse($this->conditionnement->fetchConditionnement($conditionnement));
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     */
    public function store(Request $request)
    {
        return $this->successResponse($this->conditionnement->createConditionnement($request->all()));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param                          $conditionnement
     *
     * @return mixed
     */
    public function update(Request $request, $conditionnement)
    {
        return $this->successResponse($this->conditionnement->updateConditionnement($conditionnement, $request->all()));
    }

    /**
     * @param $conditionnement
     *
     * @return mixed
     */
    public function destroy($conditionnement)
    {
        return $this->successResponse($this->conditionnement->deleteConditionnement($conditionnement));
    }
}
