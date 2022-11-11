<?php

namespace App\Services;

use App\Traits\RequestService;
use Illuminate\Http\Request;

class NiveauUrgenceService
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
        $this->path = "/api/v1/niveau_urgences";
    }

    /**
     * @return string
     */
    public function fetchNiveauUrgences(Request $request) : string
    {
        return $this->request('GET', "{$this->path}?search={$request->search}&page={$request->page}");
    }

    /**
     * @param $niveau_urgence
     *
     * @return string
     */
    public function fetchNiveauUrgence($niveau_urgence) : string
    {
        return $this->request('GET', "{$this->path}/{$niveau_urgence}");
    }

    /**
     * @param $data
     *
     * @return string
     */
    public function createNiveauUrgence($data) : string
    {
        return $this->request('POST', "{$this->path}", $data);
    }

    /**
     * @param $niveau_urgence
     * @param $data
     *
     * @return string
     */
    public function updateNiveauUrgence($niveau_urgence, $data) : string
    {
        return $this->request('PATCH', "{$this->path}/{$niveau_urgence}", $data);
    }

    /**
     * @param $niveau_urgence
     *
     * @return string
     */
    public function deleteNiveauUrgence($niveau_urgence) : string
    {
        return $this->request('DELETE', "{$this->path}/{$niveau_urgence}");
    }
}
