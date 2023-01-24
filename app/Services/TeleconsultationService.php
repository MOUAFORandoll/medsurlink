<?php

namespace App\Services;

use App\Models\Alerte;
use App\Models\Allergie;
use App\Models\Antecedent;
use App\Traits\RequestService;
use Illuminate\Http\Request;

use function GuzzleHttp\json_decode;

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
    
    public $allergie, $antecedent;

    /**
     * @var string
     */
    protected $path;

    public function __construct()
    {
        $this->baseUri = config('services.teleconsultations.base_uri');
        $this->secret = config('services.teleconsultations.secret');
        $this->path = "/api/v1/teleconsultations";
        $this->allergie = new AllergieService;
        $this->antecedent = new AntecedentService;
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
            $alerte = new AlerteService;
            $item['patient'] = $patient->getPatient($item['patient_id'], "dossier,affiliations,user");
            $item['alerte'] = $alerte->getAlerte($item['id']);
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

    public function fetchAlerte($medecin_id, $patient_id){
        $alerte = Alerte::where(['patient_id' => $patient_id, 'medecin_id' => $medecin_id, 'statut_id' => 2, 'teleconsultation_id' => NULL])->latest()->first();
        return $alerte ?? null;
    }

    public function fetchAllergies($patient_id){
        $allergies_courant = Allergie::whereHas('dossiers', function ($query) use ($patient_id) {
            $query->where('patient_id', $patient_id);
        })->latest()->get();
        if($allergies_courant->count() > 0){
            $allergies_back = json_decode($this->allergie->fetchPatientAllergie($patient_id));
            $allergies = array_merge($allergies_back->data, $allergies_courant);
        }else{
            $allergies = json_decode($this->allergie->fetchPatientAllergie($patient_id));
            $allergies = $allergies->data;
        }
        return $allergies;
    }

    public function fetchAntecedents($patient_id){
        $antecedents_courant = Antecedent::whereHas('dossier', function ($query) use ($patient_id) {
            $query->where('patient_id', $patient_id);
        })->latest()->get();
        if($antecedents_courant->count() > 0){
            $antecedents_back = json_decode($this->antecedent->fetchPatientAntecedent($patient_id));
            dd($antecedents_back->data);
            $antecedents = array_merge($antecedents_back->data, $antecedents_courant);
        }else{
            $antecedents = json_decode($this->antecedent->fetchPatientAntecedent($patient_id));
        }
        return $antecedents;
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

     /**
     * @param $teleconsultation
     *
     * @return string
     */
    public function searchTeleconsultation($patient_id, $creator, $created_at) : string
    {
        return $this->request('GET', "{$this->path}/{$patient_id}/{$creator}/{$created_at}");
    }

}
