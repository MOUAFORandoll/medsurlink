<?php

namespace App\Services;

use App\Traits\RequestService;
use Illuminate\Http\Request;

use function GuzzleHttp\json_decode;

class PrescriptionImagerieService
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

    public $niveau_urgence, $user_id;

    /**
     * @var string
     */
    protected $path;

    public function __construct()
    {
        $this->baseUri = config('services.teleconsultations.base_uri');
        $this->secret = config('services.teleconsultations.secret');
        $this->path = "/api/v1/prescription_imageries";
        $this->niveau_urgence = new NiveauUrgenceService;
        if(\Auth::guard('api')->user()){
            $this->user_id = \Auth::guard('api')->user()->id;
        }

    }

    /**
     * @return string
     */
    public function fetchPrescriptionImageries(Request $request) : string
    {
        $prescription_imageries = json_decode($this->request('GET', "{$this->path}?user_id={$this->user_id}&search={$request->search}&page={$request->page}&page_size={$request->page_size}"), true);

        $items = [];
        foreach($prescription_imageries['data']['data'] as $item){
            $patient = new PatientService;
            $item['patient'] = $patient->getPatient($item['patient_id'], "dossier,affiliations,user");
            $item['medecin'] = $patient->getMedecin($item['medecin_id']);
            $items[] = $item;
        }
        $prescription_imageries['data']['data'] = $items;

        return json_encode($prescription_imageries);
    }

    /**
     * @param $prescription_imagerie
     *
     * @return string
     */
    public function fetchPrescriptionImagerie($uuid) : string
    {

        $patient = new PatientService;

        $prescription_imagerie = json_decode($this->request('GET', "{$this->path}/{$uuid}"));
        $prescription_imagerie->data->patient = $patient->getPatient($prescription_imagerie->data->patient_id, "dossier,affiliations,user");
        $prescription_imagerie->data->medecin = $patient->getMedecin($prescription_imagerie->data->medecin_id);
        //$prescription_imagerie->data->pdf =  route('prescription_imageries.print', $prescription_imagerie->data->uuid);

        return json_encode($prescription_imagerie);
    }

    /**
     * @param $data
     *
     * @return string
     */
    public function createPrescriptionImagerie($data) : string
    {
        return $this->request('POST', "{$this->path}", $data);
    }

    /**
     * @param $prescription_imagerie
     * @param $data
     *
     * @return string
     */
    public function updatePrescriptionImagerie($prescription_imagerie, $data) : string
    {
        return $this->request('PATCH', "{$this->path}/{$prescription_imagerie}", $data);
    }

    /**
     * @param $prescription_imagerie
     *
     * @return string
     */
    public function deletePrescriptionImagerie($prescription_imagerie) : string
    {
        return $this->request('DELETE', "{$this->path}/{$prescription_imagerie}");
    }

}
