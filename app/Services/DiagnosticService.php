<?php

namespace App\Services;

use App\Traits\RequestService;
use Illuminate\Http\Request;

class DiagnosticService
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
        $this->path = "/api/v1/diagnostics";
    }

    /**
     * @return string
     */
    public function fetchDiagnostics(Request $request) : string
    {
        return $this->request('GET', "{$this->path}?search={$request->search}&page={$request->page}&page_size={$request->page_size}");
    }

    /**
     * @param $diagnostic
     *
     * @return string
     */
    public function fetchDiagnostic($diagnostic) : string
    {
        return $this->request('GET', "{$this->path}/{$diagnostic}");
    }

    /**
     * @param $data
     *
     * @return string
     */
    public function createDiagnostic($data) : string
    {
        return $this->request('POST', "{$this->path}", $data);
    }

      /**
     * @param $patient_id
     *
     * @return string
     */
    public function fetchPatientDiagnostic($patient_id) : string
    {
        return $this->request('GET', "{$this->path}/patient/{$patient_id}");
    }

    /**
     * @param $diagnostic
     * @param $data
     *
     * @return string
     */
    public function updateDiagnostic($diagnostic, $data) : string
    {
        return $this->request('PATCH', "{$this->path}/{$diagnostic}", $data);
    }

    /**
     * @param $diagnostic
     *
     * @return string
     */
    public function deleteDiagnostic($relation_id, $diagnostic, $relation) : string
    {
        return $this->request('DELETE', "{$this->path}/{$relation_id}/{$diagnostic}/{$relation}");
    }
}
