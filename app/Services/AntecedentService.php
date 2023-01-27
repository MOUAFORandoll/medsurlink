<?php

namespace App\Services;

use App\Traits\RequestService;
use Illuminate\Http\Request;

class AntecedentService
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
        $this->path = "/api/v1/antecedents";
    }

    /**
     * @return string
     */
    public function fetchAntecedents(Request $request) : string
    {
        return $this->request('GET', "{$this->path}?search={$request->search}&page={$request->page}&page_size={$request->page_size}");
    }

    /**
     * @param $patient_id
     *
     * @return string
     */
    public function fetchPatientAntecedent($patient_id) : string
    {
        return $this->request('GET', "{$this->path}/patient/{$patient_id}");
    }

    /**
     * @param $antecedent
     *
     * @return string
     */
    public function fetchAntecedent($antecedent) : string
    {
        return $this->request('GET', "{$this->path}/{$antecedent}");
    }


    /**
     * @param $data
     *
     * @return string
     */
    public function createAntecedent($data) : string
    {
        return $this->request('POST', "{$this->path}", $data);
    }

    /**
     * @param $antecedent
     * @param $data
     *
     * @return string
     */
    public function updateAntecedent($antecedent, $data) : string
    {
        return $this->request('PATCH', "{$this->path}/{$antecedent}", $data);
    }

    /**
     * @param $antecedent
     *
     * @return string
     */
    public function deleteAntecedent($antecedent) : string
    {
        return $this->request('DELETE', "{$this->path}/{$antecedent}");
    }
}
