<?php

namespace App\Services;

use App\Traits\RequestService;
use Illuminate\Http\Request;

class StatutService
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
        $this->path = "/api/v1/statuts";
    }

    /**
     * @return string
     */
    public function fetchStatuts(Request $request) : string
    {
        return $this->request('GET', "{$this->path}?search={$request->search}&page={$request->page}&page_size={$request->page_size}");
    }

    /**
     * @param $statut
     *
     * @return string
     */
    public function fetchStatut($statut) : string
    {
        return $this->request('GET', "{$this->path}/{$statut}");
    }

    /**
     * @param $data
     *
     * @return string
     */
    public function createStatut($data) : string
    {
        return $this->request('POST', "{$this->path}", $data);
    }

    /**
     * @param $statut
     * @param $data
     *
     * @return string
     */
    public function updateStatut($statut, $data) : string
    {
        return $this->request('PATCH', "{$this->path}/{$statut}", $data);
    }

    /**
     * @param $statut
     *
     * @return string
     */
    public function deleteStatut($statut) : string
    {
        return $this->request('DELETE', "{$this->path}/{$statut}");
    }
}
