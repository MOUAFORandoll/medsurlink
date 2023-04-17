<?php

namespace App\Services;

use App\Traits\RequestService;
use Illuminate\Http\Request;

class ConditionnementService
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
        $this->path = "/api/v1/conditionnements";
    }

    /**
     * @return string
     */
    public function fetchConditionnements(Request $request) : string
    {
        return $this->request('GET', "{$this->path}?search={$request->search}&page={$request->page}&page_size={$request->page_size}");
    }

    /**
     * @param $conditionnement
     *
     * @return string
     */
    public function fetchConditionnement($conditionnement) : string
    {
        return $this->request('GET', "{$this->path}/{$conditionnement}");
    }

    /**
     * @param $data
     *
     * @return string
     */
    public function createConditionnement($data) : string
    {
        return $this->request('POST', "{$this->path}", $data);
    }

      /**
     * @param $patient_id
     *
     * @return string
     */
    public function fetchPatientConditionnement($patient_id) : string
    {
        return $this->request('GET', "{$this->path}/patient/{$patient_id}");
    }

    /**
     * @param $conditionnement
     * @param $data
     *
     * @return string
     */
    public function updateConditionnement($conditionnement, $data) : string
    {
        return $this->request('PATCH', "{$this->path}/{$conditionnement}", $data);
    }

    /**
     * @param $conditionnement
     *
     * @return string
     */
    public function deleteConditionnement($conditionnement) : string
    {
        return $this->request('DELETE', "{$this->path}/{$conditionnement}");
    }
}
