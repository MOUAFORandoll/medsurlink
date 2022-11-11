<?php

namespace App\Services;

use App\Traits\RequestService;
use Illuminate\Http\Request;

class AnamneseService
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
        $this->path = "/api/v1/anamneses";
    }

    /**
     * @return string
     */
    public function fetchAnamneses(Request $request) : string
    {
        return $this->request('GET', "{$this->path}?search={$request->search}&page={$request->page}");
    }

    /**
     * @param $anamnese
     *
     * @return string
     */
    public function fetchAnamnese($anamnese) : string
    {
        return $this->request('GET', "{$this->path}/{$anamnese}");
    }

    /**
     * @param $data
     *
     * @return string
     */
    public function createAnamnese($data) : string
    {
        return $this->request('POST', "{$this->path}", $data);
    }

    /**
     * @param $anamnese
     * @param $data
     *
     * @return string
     */
    public function updateAnamnese($anamnese, $data) : string
    {
        return $this->request('PATCH', "{$this->path}/{$anamnese}", $data);
    }

    /**
     * @param $anamnese
     *
     * @return string
     */
    public function deleteAnamnese($anamnese) : string
    {
        return $this->request('DELETE', "{$this->path}/{$anamnese}");
    }
}
