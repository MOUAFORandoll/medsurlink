<?php

namespace App\Services;

use App\Models\LigneDeTemps;
use App\Traits\RequestService;
use Illuminate\Http\Request;

use function GuzzleHttp\json_decode;

class BonpriseEnChargeService
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
        $this->path = "/api/v1/bon_prises_en_charges";
        $this->niveau_urgence = new NiveauUrgenceService;
        if(\Auth::guard('api')->user()){
            $this->user_id = \Auth::guard('api')->user()->id;
        }

    }

    /**
     * @return string
     */
    public function fetchBonPriseEnCharges(Request $request) : string
    {
        $bon_prise_en_charges = json_decode($this->request('GET', "{$this->path}?user_id={$this->user_id}&search={$request->search}&page={$request->page}&page_size={$request->page_size}"), true);

        $items = [];
        foreach($bon_prise_en_charges['data']['data'] as $item){
            $patient = new PatientService;
            $item['patient'] = $patient->getPatient($item['patient_id'], "dossier,affiliations,user");
            $item['medecin'] = $patient->getMedecin($item['medecin_id']);
            $item['pdf'] =  route('bon_prise_en_charges.print', $item['uuid']);
            $items[] = $item;
        }
        $bon_prise_en_charges['data']['data'] = $items;

        return json_encode($bon_prise_en_charges);
    }

    /**
     * @param $bon_prise_en_charge
     *
     * @return string
     */
    public function fetchBonPriseEnCharge($uuid) : string
    {

        $patient = new PatientService;

        $bon_prise_en_charge = json_decode($this->request('GET', "{$this->path}/{$uuid}"));
        $bon_prise_en_charge->data->patient = $patient->getPatient($bon_prise_en_charge->data->patient_id, "dossier,affiliations,user");
        $bon_prise_en_charge->data->medecin = $patient->getMedecin($bon_prise_en_charge->data->medecin_id);
        $bon_prise_en_charge->data->pdf =  route('bon_prise_en_charges.print', $bon_prise_en_charge->data->uuid);
        $ligne_temps =  LigneDeTemps::find($bon_prise_en_charge->data->ligne_temps_id);
        $bon_prise_en_charge->data->ligne_temps =  !is_null($ligne_temps) ? $ligne_temps->load('motif:id,description,created_at', 'motifs:id,description,created_at') : null;

        return json_encode($bon_prise_en_charge);
    }

    /**
     * @param $data
     *
     * @return string
     */
    public function createBonPriseEnCharge($data) : string
    {
        return $this->request('POST', "{$this->path}", $data);
    }

    /**
     * @param $bon_prise_en_charge
     * @param $data
     *
     * @return string
     */
    public function updateBonPriseEnCharge($bon_prise_en_charge, $data) : string
    {
        return $this->request('PATCH', "{$this->path}/{$bon_prise_en_charge}", $data);
    }

    /**
     * @param $bon_prise_en_charge
     *
     * @return string
     */
    public function deleteBonPriseEnCharge($bon_prise_en_charge) : string
    {
        return $this->request('DELETE', "{$this->path}/{$bon_prise_en_charge}");
    }

}
