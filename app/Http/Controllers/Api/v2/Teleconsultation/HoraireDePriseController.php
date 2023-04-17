<?php

namespace App\Http\Controllers\Api\v2\Teleconsultation;

use App\Http\Controllers\Controller;
use App\Services\HoraireDePriseService;
use Illuminate\Http\Request;

class HoraireDePriseController extends Controller
{

    private $horaire_de_prise;

    /**
     * HoraireDePriseController constructor.
     *
     * @param \App\Services\HoraireDePriseService $horaire_de_prise
     */
    public function __construct(HoraireDePriseService $horaire_de_prise)
    {
        $this->horaire_de_prise = $horaire_de_prise;
    }

    /**
     * @return mixed
     */
    public function index(Request $request)
    {
        return $this->successResponse($this->horaire_de_prise->fetchHoraireDePrises($request));
    }

    /**
     * @param $horaire_de_prise
     *
     * @return mixed
     */
    public function show($horaire_de_prise)
    {
        return $this->successResponse($this->horaire_de_prise->fetchHoraireDePrise($horaire_de_prise));
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     */
    public function store(Request $request)
    {
        return $this->successResponse($this->horaire_de_prise->createHoraireDePrise($request->all()));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param                          $horaire_de_prise
     *
     * @return mixed
     */
    public function update(Request $request, $horaire_de_prise)
    {
        return $this->successResponse($this->horaire_de_prise->updateHoraireDePrise($horaire_de_prise, $request->all()));
    }

    /**
     * @param $horaire_de_prise
     *
     * @return mixed
     */
    public function destroy($horaire_de_prise)
    {
        return $this->successResponse($this->horaire_de_prise->deleteHoraireDePrise($horaire_de_prise));
    }
}
