<?php

namespace App\Services;

use App\Traits\RequestService;
use Illuminate\Http\Request;

class OptionFinancementService
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
        $this->path = "/api/v1/options_financements";
    }

    /**
     * @return string
     */
    public function fetchOptionFinancements(Request $request) : string
    {
        return $this->request('GET', "{$this->path}?search={$request->search}&page={$request->page}&page_size={$request->page_size}");
    }

    /**
     * @param $options_financement
     *
     * @return string
     */
    public function fetchOptionFinancement($options_financement) : string
    {
        return $this->request('GET', "{$this->path}/{$options_financement}");
    }

    /**
     * @param $data
     *
     * @return string
     */
    public function createOptionFinancement($data) : string
    {
        return $this->request('POST', "{$this->path}", $data);
    }

    /**
     * @param $options_financement
     * @param $data
     *
     * @return string
     */
    public function updateOptionFinancement($options_financement, $data) : string
    {
        return $this->request('PATCH', "{$this->path}/{$options_financement}", $data);
    }

    /**
     * @param $options_financement
     *
     * @return string
     */
    public function deleteOptionFinancement($options_financement) : string
    {
        return $this->request('DELETE', "{$this->path}/{$options_financement}");
    }
}
