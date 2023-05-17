<?php

namespace App\Services;

use App\Traits\RequestService;
use Illuminate\Http\Request;

class CategorieMedicamenteuseService
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
        $this->path = "/api/v1/categorie_medicamenteuses";
    }

    /**
     * @return string
     */
    public function fetchCategorieMedicamenteuses(Request $request) : string
    {
        return $this->request('GET', "{$this->path}?search={$request->search}&page={$request->page}&page_size={$request->page_size}");
    }

    /**
     * @param $categorie_medicamenteuse
     *
     * @return string
     */
    public function fetchCategorieMedicamenteuse($categorie_medicamenteuse) : string
    {
        return $this->request('GET', "{$this->path}/{$categorie_medicamenteuse}");
    }

    /**
     * @param $data
     *
     * @return string
     */
    public function createCategorieMedicamenteuse($data) : string
    {
        return $this->request('POST', "{$this->path}", $data);
    }

      /**
     * @param $patient_id
     *
     * @return string
     */
    public function fetchPatientCategorieMedicamenteuse($patient_id) : string
    {
        return $this->request('GET', "{$this->path}/patient/{$patient_id}");
    }

    /**
     * @param $categorie_medicamenteuse
     * @param $data
     *
     * @return string
     */
    public function updateCategorieMedicamenteuse($categorie_medicamenteuse, $data) : string
    {
        return $this->request('PATCH', "{$this->path}/{$categorie_medicamenteuse}", $data);
    }

    /**
     * @param $categorie_medicamenteuse
     *
     * @return string
     */
    public function deleteCategorieMedicamenteuse($categorie_medicamenteuse) : string
    {
        return $this->request('DELETE', "{$this->path}/{$categorie_medicamenteuse}");
    }
}
