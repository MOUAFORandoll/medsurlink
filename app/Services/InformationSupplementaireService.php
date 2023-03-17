<?php

namespace App\Services;

use App\Traits\RequestService;
use Illuminate\Http\Request;

class InformationSupplementaireService
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
        $this->path = "/api/v1/informations_supplementaires";
    }

    /**
     * @return string
     */
    public function fetchInformationSupplementaires(Request $request) : string
    {
        return $this->request('GET', "{$this->path}?search={$request->search}&page={$request->page}&page_size={$request->page_size}");
    }

    /**
     * @param $information_supplementaire
     *
     * @return string
     */
    public function fetchInformationSupplementaire($information_supplementaire) : string
    {
        return $this->request('GET', "{$this->path}/{$information_supplementaire}");
    }

    /**
     * @param $data
     *
     * @return string
     */
    public function createInformationSupplementaire($data) : string
    {
        return $this->request('POST', "{$this->path}", $data);
    }

    /**
     * @param $information_supplementaire
     * @param $data
     *
     * @return string
     */
    public function updateInformationSupplementaire($information_supplementaire, $data) : string
    {
        return $this->request('PATCH', "{$this->path}/{$information_supplementaire}", $data);
    }

    /**
     * @param $information_supplementaire
     *
     * @return string
     */
    public function deleteInformationSupplementaire($information_supplementaire) : string
    {
        return $this->request('DELETE', "{$this->path}/{$information_supplementaire}");
    }
}
