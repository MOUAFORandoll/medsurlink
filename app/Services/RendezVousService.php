<?php

namespace App\Services;

use App\Models\LigneDeTemps;
use App\Traits\RequestService;
use Illuminate\Http\Request;

class RendezVousService
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
    public $statut, $etablissement;

    public function __construct()
    {
        $this->baseUri = config('services.teleconsultations.base_uri');
        $this->secret = config('services.teleconsultations.secret');
        $this->path = "/api/v1/rendez_vous";

        $this->statut = new StatutService;
        $this->etablissement = new EtablissementService;
    }

    /**
     * @return string
     */
    public function fetchRendezVouss(Request $request) : string
    {

        $rendez_vous = json_decode($this->request('GET', "{$this->path}?search={$request->search}&page={$request->page}&page_size={$request->page_size}&statut_id={$request->statut_id}"), true);

        $items = [];
        $statuts = collect(json_decode($this->statut->fetchStatuts($request), true)['data']);
        $patient = new PatientService;
        foreach($rendez_vous['data']['data'] as $item){
            $ligne_temps =  LigneDeTemps::find($item['ligne_temps_id']);
            $item['statut'] = $statuts->where('id', $item['statut_id'])->first();
            $item['patient'] = $patient->getPatient($item['patient_id'], "dossier,affiliations,user");
            $item['medecin'] = $patient->getPraticien($item['praticien_id']);
            if(!is_null($item['etablissement_id'])){
                $item['etablissement'] = json_decode($this->etablissement->fetchEtablissement($item['etablissement_id']), true)['data'];
            }
            $item['ligne_temps'] = !is_null($ligne_temps) ? $ligne_temps->load('motif:id,description,created_at', 'motifs:id,description,created_at') : null;
            $items[] = $item;
        }
        $rendez_vous['data']['data'] = $items;

        return json_encode($rendez_vous);
    }

    /**
     * @param $rendez_vous
     *
     * @return string
     */
    public function fetchRendezVous($rendez_vous) : string
    {
        $patient = new PatientService;

        $rendez_vous = json_decode($this->request('GET', "{$this->path}/{$rendez_vous}"));
        $rendez_vous->data->patient = $patient->getPatient($rendez_vous->data->patient_id, "dossier,affiliations,user");
        $rendez_vous->data->medecin = $patient->getPraticien($rendez_vous->data->praticien_id);
        if(!is_null($rendez_vous->data->etablissement_id)){
            $rendez_vous->etablissement = json_decode($this->etablissement->fetchEtablissement($rendez_vous->data->etablissement_id), true)['data'];
        }
        $ligne_temps =  LigneDeTemps::find($rendez_vous->data->ligne_temps_id);
        $rendez_vous->data->ligne_temps =  !is_null($ligne_temps) ? $ligne_temps->load('motif:id,description,created_at', 'motifs:id,description,created_at') : null;

        return json_encode($rendez_vous);

    }

    public function fetchTomorrowRendezVous()
    {

        $rendez_vous = collect(json_decode($this->request('GET', "{$this->path}/jours/demain"), true)['data']);
        $rdv_demain = collect();
        $patient = new PatientService;
        $etablissement = new EtablissementService;
        foreach($rendez_vous as $rdv){
            $rdv['patient'] = $patient->getPatient($rdv['patient_id'], "user");
            $rdv['medecin'] = $patient->getMedecin($rdv['creator'], "user");
            $rdv['etablissement'] = json_decode($etablissement->fetchEtablissement($rdv['etablissement_id']), true)['data'];
            $rdv_demain->push($rdv);
        }
        return $rdv_demain;
    }

    /**
     * @param $data
     *
     * @return string
     */
    public function createRendezVous($data) : string
    {
        return $this->request('POST', "{$this->path}", $data);
    }

    /**
     * @param $rendez_vous
     * @param $data
     *
     * @return string
     */
    public function updateRendezVous($rendez_vous, $data) : string
    {
        return $this->request('PATCH', "{$this->path}/{$rendez_vous}", $data);
    }

    /**
     * @param $rendez_vous
     *
     * @return string
     */
    public function deleteRendezVous($rendez_vous) : string
    {
        return $this->request('DELETE', "{$this->path}/{$rendez_vous}");
    }
}
