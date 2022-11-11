<?php

namespace App\Services;

use App\Traits\RequestService;
use Illuminate\Http\Request;

class ExamenCliniqueService
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
        $this->path = "/api/v1/examen_cliniques";
    }

    /**
     * @return string
     */
    public function fetchExamenCliniques(Request $request) : string
    {
        return $this->request('GET', "{$this->path}?search={$request->search}&page={$request->page}");
    }

    /**
     * @param $examen_clinique
     *
     * @return string
     */
    public function fetchExamenClinique($examen_clinique) : string
    {
        return $this->request('GET', "{$this->path}/{$examen_clinique}");
    }

    /**
     * @param $data
     *
     * @return string
     */
    public function createExamenClinique($data) : string
    {
        return $this->request('POST', "{$this->path}", $data);
    }

    /**
     * @param $examen_clinique
     * @param $data
     *
     * @return string
     */
    public function updateExamenClinique($examen_clinique, $data) : string
    {
        return $this->request('PATCH', "{$this->path}/{$examen_clinique}", $data);
    }

    /**
     * @param $examen_clinique
     *
     * @return string
     */
    public function deleteExamenClinique($examen_clinique) : string
    {
        return $this->request('DELETE', "{$this->path}/{$examen_clinique}");
    }
}
