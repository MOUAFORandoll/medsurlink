<?php

namespace App\Http\Controllers\Api\v2\Teleconsultation;

use App\Http\Controllers\Controller;
use App\Services\MotifService;
use Illuminate\Http\Request;

class MotifController extends Controller
{

    private $motifs;

    /**
     * MotifController constructor.
     *
     * @param \App\Services\MotifService $motifs
     */
    public function __construct(MotifService $motifs)
    {
        $this->motifs = $motifs;
    }

    /**
     * @return mixed
     */
    public function index(Request $request)
    {
        return $this->successResponse($this->motifs->fetchMotifs($request));
    }

    /**
     * @param $motif
     *
     * @return mixed
     */
    public function show($motif)
    {
        return $this->successResponse($this->motifs->fetchMotif($motif));
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     */
    public function store(Request $request)
    {
        return $this->successResponse($this->motifs->createMotif($request->all()));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param                          $motif
     *
     * @return mixed
     */
    public function update(Request $request, $motif)
    {
        return $this->successResponse($this->motifs->updateMotif($motif, $request->all()));
    }

    /**
     * @param $motif
     *
     * @return mixed
     */
    public function destroy($motif)
    {
        return $this->successResponse($this->motifs->deleteMotif($motif));
    }
}
