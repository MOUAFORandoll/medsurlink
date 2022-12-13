<?php

namespace App\Services;

use App\Traits\RequestService;
use Illuminate\Http\Request;

class TypeService
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
        $this->path = "/api/v1/types";
    }

    /**
     * @return string
     */
    public function fetchTypes(Request $request) : string
    {
        return $this->request('GET', "{$this->path}?search={$request->search}&type={$request->type}");
    }

    /**
     * @param $type
     *
     * @return string
     */
    public function fetchType($type) : string
    {
        return $this->request('GET', "{$this->path}/{$type}");
    }

    /**
     * @param $data
     *
     * @return string
     */
    public function createType($data) : string
    {
        return $this->request('POST', "{$this->path}", $data);
    }

    /**
     * @param $type
     * @param $data
     *
     * @return string
     */
    public function updateType($type, $data) : string
    {
        return $this->request('PATCH', "{$this->path}/{$type}", $data);
    }

    /**
     * @param $type
     *
     * @return string
     */
    public function deleteType($type) : string
    {
        return $this->request('DELETE', "{$this->path}/{$type}");
    }
}
