<?php

namespace App\Services;

use App\Traits\RequestService;
use Illuminate\Http\Request;

class ExamenComplementaireService
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
        $this->path = "/api/v1/examen_complementaires";
    }

    /**
     * @return string
     */
    public function fetchExamenComplementaires(Request $request) : string
    {
        return $this->request('GET', "{$this->path}?search={$request->search}&page={$request->page}&page_size={$request->page_size}");
    }

    /**
     * @param $examen_complementaire
     *
     * @return string
     */
    public function fetchExamenComplementaire($examen_complementaire) : string
    {
        return $this->request('GET', "{$this->path}/{$examen_complementaire}");
    }

    /**
     * @param $data
     *
     * @return string
     */
    public function createExamenComplementaire($data) : string
    {
        return $this->request('POST', "{$this->path}", $data);
    }

    /**
     * @param $examen_complementaire
     * @param $data
     *
     * @return string
     */
    public function updateExamenComplementaire($examen_complementaire, $data) : string
    {
        return $this->request('PATCH', "{$this->path}/{$examen_complementaire}", $data);
    }

    /**
     * @param $examen_complementaire
     *
     * @return string
     */
    public function deleteExamenComplementaire($relation_id, $examen_complementaire, $relation) : string
    {
        return $this->request('DELETE', "{$this->path}/{$relation_id}/{$examen_complementaire}/{$relation}");
    }
}
