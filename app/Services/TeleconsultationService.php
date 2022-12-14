<?php

namespace App\Services;

use App\Traits\RequestService;
use Illuminate\Http\Request;

class TeleconsultationService
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
        $this->path = "/api/v1/teleconsultations";
    }

    /**
     * @return string
     */
    public function fetchTeleconsultations(Request $request) : string
    {
        $teleconsultations = json_decode($this->request('GET', "{$this->path}?search={$request->search}&page={$request->page}&page_size={$request->page_size}"), true);

        $items = [];
        foreach($teleconsultations['data']['data'] as $item){
            $patient = new PatientService;
            $item['patient'] = $patient->getPatient($item['patient_id'], "dossier,affiliations,user");
            $items[] = $item;
        }
        $teleconsultations['data']['data'] = $items;

        return json_encode($teleconsultations);
    }

    /**
     * @param $teleconsultation
     *
     * @return string
     */
    public function fetchTeleconsultation($teleconsultation) : string
    {
        return $this->request('GET', "{$this->path}/{$teleconsultation}");
    }

    /**
     * @param $data
     *
     * @return string
     */
    public function createTeleconsultation($data) : string
    {
        return $this->request('POST', "{$this->path}", $data);
    }

    /**
     * @param $teleconsultation
     * @param $data
     *
     * @return string
     */
    public function updateTeleconsultation($teleconsultation, $data) : string
    {
        return $this->request('PATCH', "{$this->path}/{$teleconsultation}", $data);
    }

    /**
     * @param $teleconsultation
     *
     * @return string
     */
    public function deleteTeleconsultation($teleconsultation) : string
    {
        return $this->request('DELETE', "{$this->path}/{$teleconsultation}");
    }
}
