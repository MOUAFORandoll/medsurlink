<?php

namespace App\Services;

use App\Traits\RequestService;
use Illuminate\Http\Request;

class UnitePresentationService
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
        $this->path = "/api/v1/unite_presentations";
    }

    /**
     * @return string
     */
    public function fetchUnitePresentations(Request $request) : string
    {
        return $this->request('GET', "{$this->path}?search={$request->search}&page={$request->page}&page_size={$request->page_size}");
    }

    /**
     * @param $unite_presentation
     *
     * @return string
     */
    public function fetchUnitePresentation($unite_presentation) : string
    {
        return $this->request('GET', "{$this->path}/{$unite_presentation}");
    }

    /**
     * @param $data
     *
     * @return string
     */
    public function createUnitePresentation($data) : string
    {
        return $this->request('POST', "{$this->path}", $data);
    }

      /**
     * @param $patient_id
     *
     * @return string
     */
    public function fetchPatientUnitePresentation($patient_id) : string
    {
        return $this->request('GET', "{$this->path}/patient/{$patient_id}");
    }

    /**
     * @param $unite_presentation
     * @param $data
     *
     * @return string
     */
    public function updateUnitePresentation($unite_presentation, $data) : string
    {
        return $this->request('PATCH', "{$this->path}/{$unite_presentation}", $data);
    }

    /**
     * @param $unite_presentation
     *
     * @return string
     */
    public function deleteUnitePresentation($unite_presentation) : string
    {
        return $this->request('DELETE', "{$this->path}/{$unite_presentation}");
    }
}


