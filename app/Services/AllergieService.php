<?php

namespace App\Services;

use App\Traits\RequestService;
use Illuminate\Http\Request;

class AllergieService
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
        $this->path = "/api/v1/allergies";
    }

    /**
     * @return string
     */
    public function fetchAllergies(Request $request) : string
    {
        return $this->request('GET', "{$this->path}?search={$request->search}&page={$request->page}&page_size={$request->page_size}");
    }

    /**
     * @param $allergie
     *
     * @return string
     */
    public function fetchAllergie($allergie) : string
    {
        return $this->request('GET', "{$this->path}/{$allergie}");
    }

    /**
     * @param $data
     *
     * @return string
     */
    public function createAllergie($data) : string
    {
        return $this->request('POST', "{$this->path}", $data);
    }

      /**
     * @param $patient_id
     *
     * @return string
     */
    public function fetchPatientAllergie($patient_id) : string
    {
        return $this->request('GET', "{$this->path}/patient/{$patient_id}");
    }

    /**
     * @param $allergie
     * @param $data
     *
     * @return string
     */
    public function updateAllergie($allergie, $data) : string
    {
        return $this->request('PATCH', "{$this->path}/{$allergie}", $data);
    }

    /**
     * @param $allergie
     *
     * @return string
     */
    public function deleteAllergie($relation_id, $allergie, $relation) : string
    {
        return $this->request('DELETE', "{$this->path}/{$relation_id}/{$allergie}/{$relation}");
    }
}
