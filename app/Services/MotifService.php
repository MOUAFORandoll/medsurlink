<?php

namespace App\Services;

use App\Traits\RequestService;
use Illuminate\Http\Request;

class MotifService
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
        $this->path = "/api/v1/motifs";
    }

    /**
     * @return string
     */
    public function fetchMotifs(Request $request) : string
    {
        return $this->request('GET', "{$this->path}?search={$request->search}&page={$request->page}&page_size={$request->page_size}");
    }

    /**
     * @param $motif
     *
     * @return string
     */
    public function fetchMotif($motif) : string
    {
        return $this->request('GET', "{$this->path}/{$motif}");
    }

    /**
     * @param $data
     *
     * @return string
     */
    public function createMotif($data) : string
    {
        return $this->request('POST', "{$this->path}", $data);
    }

    /**
     * @param $motif
     * @param $data
     *
     * @return string
     */
    public function updateMotif($motif, $data) : string
    {
        return $this->request('PATCH', "{$this->path}/{$motif}", $data);
    }

    /**
     * @param $motif
     *
     * @return string
     */
    public function deleteMotif($motif) : string
    {
        return $this->request('DELETE', "{$this->path}/{$motif}");
    }
}
