<?php

namespace App\Services;

use App\Traits\RequestService;
use Illuminate\Http\Request;

class RendezVousService
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
        $this->path = "/api/v1/rendez_vous";
    }

    /**
     * @return string
     */
    public function fetchRendezVouss(Request $request) : string
    {
        return $this->request('GET', "{$this->path}?search={$request->search}&page={$request->page}");
    }

    /**
     * @param $rendez_vous
     *
     * @return string
     */
    public function fetchRendezVous($rendez_vous) : string
    {
        return $this->request('GET', "{$this->path}/{$rendez_vous}");
    }

    /**
     * @param $data
     *
     * @return string
     */
    public function createRendezVous($data) : string
    {
        return $this->request('POST', "{$this->path}", $data);
    }

    /**
     * @param $rendez_vous
     * @param $data
     *
     * @return string
     */
    public function updateRendezVous($rendez_vous, $data) : string
    {
        return $this->request('PATCH', "{$this->path}/{$rendez_vous}", $data);
    }

    /**
     * @param $rendez_vous
     *
     * @return string
     */
    public function deleteRendezVous($rendez_vous) : string
    {
        return $this->request('DELETE', "{$this->path}/{$rendez_vous}");
    }
}
