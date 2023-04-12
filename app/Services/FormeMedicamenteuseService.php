<?php

namespace App\Services;

use App\Traits\RequestService;
use Illuminate\Http\Request;

class FormeMedicamenteuseService
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
        $this->path = "/api/v1/forme_medicamenteuses";
    }

    /**
     * @return string
     */
    public function fetchFormeMedicamenteuses(Request $request) : string
    {
        return $this->request('GET', "{$this->path}?search={$request->search}&page={$request->page}&page_size={$request->page_size}&categorie_medicamenteuse_id={$request->categorie_medicamenteuse_id}");
    }

    /**
     * @param $forme_medicamenteuse
     *
     * @return string
     */
    public function fetchFormeMedicamenteuse($forme_medicamenteuse) : string
    {
        return $this->request('GET', "{$this->path}/{$forme_medicamenteuse}");
    }

    /**
     * @param $data
     *
     * @return string
     */
    public function createFormeMedicamenteuse($data) : string
    {
        return $this->request('POST', "{$this->path}", $data);
    }

      /**
     * @param $patient_id
     *
     * @return string
     */
    public function fetchPatientFormeMedicamenteuse($patient_id) : string
    {
        return $this->request('GET', "{$this->path}/patient/{$patient_id}");
    }

    /**
     * @param $forme_medicamenteuse
     * @param $data
     *
     * @return string
     */
    public function updateFormeMedicamenteuse($forme_medicamenteuse, $data) : string
    {
        return $this->request('PATCH', "{$this->path}/{$forme_medicamenteuse}", $data);
    }

    /**
     * @param $forme_medicamenteuse
     *
     * @return string
     */
    public function deleteFormeMedicamenteuse($forme_medicamenteuse) : string
    {
        return $this->request('DELETE', "{$this->path}/{$forme_medicamenteuse}");
    }
}
