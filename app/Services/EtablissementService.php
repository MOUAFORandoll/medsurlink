<?php

namespace App\Services;

use App\Traits\RequestService;
use Illuminate\Http\Request;

class EtablissementService
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
        $this->path = "/api/v1/etablissements";
    }

    /**
     * @return string
     */
    public function fetchEtablissements(Request $request) : string
    {
        return $this->request('GET', "{$this->path}?search={$request->search}&page={$request->page}");
    }

    /**
     * @param $etablissement
     *
     * @return string
     */
    public function fetchEtablissement($etablissement) : string
    {
        return $this->request('GET', "{$this->path}/{$etablissement}");
    }

    /**
     * @param $data
     *
     * @return string
     */
    public function createEtablissement($data) : string
    {
        return $this->request('POST', "{$this->path}", $data);
    }

    /**
     * @param $etablissement
     * @param $data
     *
     * @return string
     */
    public function updateEtablissement($etablissement, $data) : string
    {
        return $this->request('PATCH', "{$this->path}/{$etablissement}", $data);
    }

    /**
     * @param $etablissement
     *
     * @return string
     */
    public function deleteEtablissement($etablissement) : string
    {
        return $this->request('DELETE', "{$this->path}/{$etablissement}");
    }
}
