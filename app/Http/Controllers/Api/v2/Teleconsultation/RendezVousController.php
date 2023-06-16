<?php

namespace App\Http\Controllers\Api\v2\Teleconsultation;

use App\Http\Controllers\Controller;
use App\Services\RendezVousService;
use Illuminate\Http\Request;

class RendezVousController extends Controller
{

    private $rendezVous;

    /**
     * RendezVousController constructor.
     *
     * @param \App\Services\RendezVousService $rendezVous
     */
    public function __construct(RendezVousService $rendezVous)
    {
        $this->rendezVous = $rendezVous;
    }

    /**
     * @return mixed
     */
    public function index(Request $request)
    {
        return $this->successResponse($this->rendezVous->fetchRendezVouss($request));
    }

    /**
     * @param $rendez_vous
     *
     * @return mixed
     */
    public function show($rendez_vous)
    {
        return $this->successResponse($this->rendezVous->fetchRendezVous($rendez_vous));
    }

    /**
     * @return mixed
     */
    public function demain()
    {
        return $this->successResponse($this->rendezVous->fetchTomorrowRendezVous());
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     */
    public function store(Request $request)
    {
        return $this->successResponse($this->rendezVous->createRendezVous($request->all()));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param                          $rendez_vous
     *
     * @return mixed
     */
    public function update(Request $request, $rendez_vous)
    {
        return $this->successResponse($this->rendezVous->updateRendezVous($rendez_vous, $request->all()));
    }

    /**
     * @param $rendez_vous
     *
     * @return mixed
     */
    public function destroy($rendez_vous)
    {
        return $this->successResponse($this->rendezVous->deleteRendezVous($rendez_vous));
    }
}
