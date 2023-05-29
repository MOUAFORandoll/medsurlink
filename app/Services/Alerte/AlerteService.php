<?php

namespace App\Services\Alerte;

use App\Traits\RequestService;
use Illuminate\Http\Request;

class AlerteService
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
        $this->path = "/api/v1/alertes";
    }

    /**
     * @return string
     */
    public function fetchAlertes(Request $request) : string
    {
        return $this->request('GET', "{$this->path}?search={$request->search}&page={$request->page}&page_size={$request->page_size}");
    }
    
    /**
     * @param $alerte
     *
     * @return string
     */
    public function fetchAlerte($alerte) : string
    {
        return $this->request('GET', "{$this->path}/{$alerte}");
    }

    /**
     * @param $user_id
     *
     * @return string
     */
    public function historyInfoUserAlert($user_id) : string
    {
        return $this->request('GET', "{$this->path}/info/{$user_id}");
    }

    /**
     * @param $alerte
     * @param $data
     *
     * @return string
     */
    public function subScribeAlerte($alerte, $data) : string
    {
        return $this->request('PATCH', "{$this->path}/{$alerte}/subscribe", $data);
    }

    /**
     * @param $data
     *
     * @return string
     */
    public function createAlerte($data) : string
    {
        return $this->request('POST', "{$this->path}", $data);
    }

    /**
     * @param $alerte
     * @param $data
     *
     * @return string
     */
    public function updateAlerte($alerte, $data) : string
    {
        return $this->request('PATCH', "{$this->path}/{$alerte}", $data);
    }

    /**
     * @param $alerte
     *
     * @return string
     */
    public function deleteAlerte($alerte) : string
    {
        return $this->request('DELETE', "{$this->path}/{$alerte}");
    }
}
