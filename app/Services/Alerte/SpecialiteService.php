<?php

namespace App\Services\Alerte;

use App\Traits\RequestService;
use Illuminate\Http\Request;

class SpecialiteService
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
        $this->baseUri = config('services.alertes.base_uri');
        $this->secret = config('services.alertes.secret');
        $this->path = "/api/v1/specialities";
    }

    /**
     * @return string
     */
    public function fetchSpecialites(Request $request) : string
    {
        return $this->request('GET', "{$this->path}?search={$request->search}&page={$request->page}&page_size={$request->page_size}");
    }

    /**
     * @param $specialite
     *
     * @return string
     */
    public function fetchSpecialite($specialite) : string
    {
        return $this->request('GET', "{$this->path}/{$specialite}");
    }

    /**
     * @param $data
     *
     * @return string
     */
    public function createSpecialite($data) : string
    {
        return $this->request('POST', "{$this->path}", $data);
    }

    /**
     * @param $specialite
     * @param $data
     *
     * @return string
     */
    public function updateSpecialite($specialite, $data) : string
    {
        return $this->request('PATCH', "{$this->path}/{$specialite}", $data);
    }

    /**
     * @param $specialite
     *
     * @return string
     */
    public function deleteSpecialite($specialite) : string
    {
        return $this->request('DELETE', "{$this->path}/{$specialite}");
    }
}
