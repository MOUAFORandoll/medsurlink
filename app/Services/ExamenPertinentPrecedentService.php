<?php

namespace App\Services;

use App\Traits\RequestService;
use Illuminate\Http\Request;

class ExamenPertinentPrecedentService
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
        $this->path = "/api/v1/examens_pertinents";
    }

    /**
     * @return string
     */
    public function fetchExamenPertinents(Request $request) : string
    {
        return $this->request('GET', "{$this->path}?search={$request->search}&page={$request->page}&page_size={$request->page_size}");
    }

    /**
     * @param $examen_pertinent
     *
     * @return string
     */
    public function fetchExamenPertinent($examen_pertinent) : string
    {
        return $this->request('GET', "{$this->path}/{$examen_pertinent}");
    }

    /**
     * @param $data
     *
     * @return string
     */
    public function createExamenPertinent($data) : string
    {
        return $this->request('POST', "{$this->path}", $data);
    }

    /**
     * @param $examen_pertinent
     * @param $data
     *
     * @return string
     */
    public function updateExamenPertinent($examen_pertinent, $data) : string
    {
        return $this->request('PATCH', "{$this->path}/{$examen_pertinent}", $data);
    }

    /**
     * @param $examen_pertinent
     *
     * @return string
     */
    public function deleteExamenPertinent($examen_pertinent) : string
    {
        return $this->request('DELETE', "{$this->path}/{$examen_pertinent}");
    }
}
