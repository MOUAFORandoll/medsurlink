<?php

namespace App\Services;

use App\Traits\RequestService;
use Illuminate\Http\Request;

class VoieAdministrationService
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
        $this->path = "/api/v1/voie_administrations";
    }

    /**
     * @return string
     */
    public function fetchVoieAdministrations(Request $request) : string
    {
        return $this->request('GET', "{$this->path}?search={$request->search}&page={$request->page}&page_size={$request->page_size}");
    }

    /**
     * @param $voie_administration
     *
     * @return string
     */
    public function fetchVoieAdministration($voie_administration) : string
    {
        return $this->request('GET', "{$this->path}/{$voie_administration}");
    }

    /**
     * @param $data
     *
     * @return string
     */
    public function createVoieAdministration($data) : string
    {
        return $this->request('POST', "{$this->path}", $data);
    }

      /**
     * @param $patient_id
     *
     * @return string
     */
    public function fetchPatientVoieAdministration($patient_id) : string
    {
        return $this->request('GET', "{$this->path}/patient/{$patient_id}");
    }

    /**
     * @param $voie_administration
     * @param $data
     *
     * @return string
     */
    public function updateVoieAdministration($voie_administration, $data) : string
    {
        return $this->request('PATCH', "{$this->path}/{$voie_administration}", $data);
    }

    /**
     * @param $voie_administration
     *
     * @return string
     */
    public function deleteVoieAdministration($voie_administration) : string
    {
        return $this->request('DELETE', "{$this->path}/{$voie_administration}");
    }
}
