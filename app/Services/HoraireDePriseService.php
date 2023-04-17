<?php

namespace App\Services;

use App\Traits\RequestService;
use Illuminate\Http\Request;

class HoraireDePriseService
{
    use RequestService;

    /**
     * @var string
     */
    protected $baseUri;

    /**
     * @var string
     */
    protected $secret;
    /**
     * @var string
     */
    protected $path;

    public function __construct()
    {
        $this->baseUri = config('services.teleconsultations.base_uri');
        $this->secret = config('services.teleconsultations.secret');
        $this->path = "/api/v1/horaire_de_prises";
    }

    /**
     * @return string
     */
    public function fetchHoraireDePrises(Request $request) : string
    {
        return $this->request('GET', "{$this->path}?search={$request->search}&page={$request->page}&page_size={$request->page_size}");
    }

    /**
     * @param $horaire_de_prise
     *
     * @return string
     */
    public function fetchHoraireDePrise($horaire_de_prise) : string
    {
        return $this->request('GET', "{$this->path}/{$horaire_de_prise}");
    }

    /**
     * @param $data
     *
     * @return string
     */
    public function createHoraireDePrise($data) : string
    {
        return $this->request('POST', "{$this->path}", $data);
    }

      /**
     * @param $patient_id
     *
     * @return string
     */
    public function fetchPatientHoraireDePrise($patient_id) : string
    {
        return $this->request('GET', "{$this->path}/patient/{$patient_id}");
    }

    /**
     * @param $horaire_de_prise
     * @param $data
     *
     * @return string
     */
    public function updateHoraireDePrise($horaire_de_prise, $data) : string
    {
        return $this->request('PATCH', "{$this->path}/{$horaire_de_prise}", $data);
    }

    /**
     * @param $horaire_de_prise
     *
     * @return string
     */
    public function deleteHoraireDePrise($horaire_de_prise) : string
    {
        return $this->request('DELETE', "{$this->path}/{$horaire_de_prise}");
    }
}
