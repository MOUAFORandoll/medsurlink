<?php

namespace App\Services;

use App\Traits\RequestService;
use Illuminate\Http\Request;

class RaisonPrescriptionService
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
        $this->path = "/api/v1/raison_prescriptions";
    }

    /**
     * @return string
     */
    public function fetchRaisonPrescriptions(Request $request) : string
    {
        return $this->request('GET', "{$this->path}?search={$request->search}&page={$request->page}&page_size={$request->page_size}");
    }

    /**
     * @param $raison_prescription
     *
     * @return string
     */
    public function fetchRaisonPrescription($raison_prescription) : string
    {
        return $this->request('GET', "{$this->path}/{$raison_prescription}");
    }

    /**
     * @param $data
     *
     * @return string
     */
    public function createRaisonPrescription($data) : string
    {
        return $this->request('POST', "{$this->path}", $data);
    }

    /**
     * @param $raison_prescription
     * @param $data
     *
     * @return string
     */
    public function updateRaisonPrescription($raison_prescription, $data) : string
    {
        return $this->request('PATCH', "{$this->path}/{$raison_prescription}", $data);
    }

    /**
     * @param $raison_prescription
     *
     * @return string
     */
    public function deleteRaisonPrescription($raison_prescription) : string
    {
        return $this->request('DELETE', "{$this->path}/{$raison_prescription}");
    }
}
