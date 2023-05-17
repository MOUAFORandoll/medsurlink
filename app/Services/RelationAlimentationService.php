<?php

namespace App\Services;

use App\Traits\RequestService;
use Illuminate\Http\Request;

class RelationAlimentationService
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
        $this->path = "/api/v1/relation_alimentaires";
    }

    /**
     * @return string
     */
    public function fetchRelationAlimentations(Request $request) : string
    {
        return $this->request('GET', "{$this->path}?search={$request->search}&page={$request->page}&page_size={$request->page_size}");
    }

    /**
     * @param $relation_alimentaire
     *
     * @return string
     */
    public function fetchRelationAlimentation($relation_alimentaire) : string
    {
        return $this->request('GET', "{$this->path}/{$relation_alimentaire}");
    }

    /**
     * @param $data
     *
     * @return string
     */
    public function createRelationAlimentation($data) : string
    {
        return $this->request('POST', "{$this->path}", $data);
    }

      /**
     * @param $patient_id
     *
     * @return string
     */
    public function fetchPatientRelationAlimentation($patient_id) : string
    {
        return $this->request('GET', "{$this->path}/patient/{$patient_id}");
    }

    /**
     * @param $relation_alimentaire
     * @param $data
     *
     * @return string
     */
    public function updateRelationAlimentation($relation_alimentaire, $data) : string
    {
        return $this->request('PATCH', "{$this->path}/{$relation_alimentaire}", $data);
    }

    /**
     * @param $relation_alimentaire
     *
     * @return string
     */
    public function deleteRelationAlimentation($relation_alimentaire) : string
    {
        return $this->request('DELETE', "{$this->path}/{$relation_alimentaire}");
    }
}
