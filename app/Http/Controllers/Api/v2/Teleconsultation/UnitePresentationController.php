<?php

namespace App\Http\Controllers\Api\v2\Teleconsultation;

use App\Http\Controllers\Controller;
use App\Services\UnitePresentationService;
use Illuminate\Http\Request;

class UnitePresentationController extends Controller
{

    private $unite_presentation;

    /**
     * UnitePresentationController constructor.
     *
     * @param \App\Services\UnitePresentationService $unite_presentation
     */
    public function __construct(UnitePresentationService $unite_presentation)
    {
        $this->unite_presentation = $unite_presentation;
    }

    /**
     * @return mixed
     */
    public function index(Request $request)
    {
        return $this->successResponse($this->unite_presentation->fetchUnitePresentations($request));
    }

    /**
     * @param $unite_presentation
     *
     * @return mixed
     */
    public function show($unite_presentation)
    {
        return $this->successResponse($this->unite_presentation->fetchUnitePresentation($unite_presentation));
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     */
    public function store(Request $request)
    {
        return $this->successResponse($this->unite_presentation->createUnitePresentation($request->all()));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param                          $unite_presentation
     *
     * @return mixed
     */
    public function update(Request $request, $unite_presentation)
    {
        return $this->successResponse($this->unite_presentation->updateUnitePresentation($unite_presentation, $request->all()));
    }

    /**
     * @param $unite_presentation
     *
     * @return mixed
     */
    public function destroy($unite_presentation)
    {
        return $this->successResponse($this->unite_presentation->deleteUnitePresentation($unite_presentation));
    }
}
