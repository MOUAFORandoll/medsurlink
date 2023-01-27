<?php

namespace App\Services;

use App\Traits\RequestService;
use Illuminate\Http\Request;

class OrdonnanceService
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
        $this->path = "/api/v1/ordonnances";
    }

    /**
     * @return string
     */
    public function fetchOrdonnances(Request $request) : string
    {
        return $this->request('GET', "{$this->path}?search={$request->search}&page={$request->page}&page_size={$request->page_size}");
    }

    /**
     * @param $ordonnance
     *
     * @return string
     */
    public function fetchOrdonnance($ordonnance) : string
    {
        return $this->request('GET', "{$this->path}/{$ordonnance}");
    }

    /**
     * @param $data
     *
     * @return string
     */
    public function createOrdonnance($data) : string
    {
        return $this->request('POST', "{$this->path}", $data);
    }

      /**
     * @param $patient_id
     *
     * @return string
     */
    public function fetchPatientOrdonnance($patient_id) : string
    {
        return $this->request('GET', "{$this->path}/patient/{$patient_id}");
    }

    /**
     * @param $ordonnance
     * @param $data
     *
     * @return string
     */
    public function updateOrdonnance($ordonnance, $data) : string
    {
        return $this->request('PATCH', "{$this->path}/{$ordonnance}", $data);
    }

    /**
     * @param $ordonnance
     *
     * @return string
     */
    public function deleteOrdonnance($relation_id, $ordonnance, $relation) : string
    {
        return $this->request('DELETE', "{$this->path}/{$relation_id}/{$ordonnance}/{$relation}");
    }
}
