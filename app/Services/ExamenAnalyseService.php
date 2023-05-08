<?php

namespace App\Services;

use App\Models\LigneDeTemps;
use App\Traits\RequestService;
use Illuminate\Http\Request;

use function GuzzleHttp\json_decode;

class ExamenAnalyseService
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
        $this->path = "/api/v1/examen_analyses";
        $this->niveau_urgence = new NiveauUrgenceService;
        if (\Auth::guard('api')->user()) {
            $this->user_id = \Auth::guard('api')->user()->id;
        }
    }

    /**
     * @return string
     */
    public function fetchExamenAnalyses(Request $request): string
    {
        $examen_analyses = json_decode($this->request('GET', "{$this->path}?user_id={$this->user_id}&search={$request->search}&page={$request->page}&page_size={$request->page_size}&patients={$request->patients}"), true);

        $items = [];
        $patient = new PatientService;
        foreach ($examen_analyses['data']['data'] as $item) {
            $item['patient'] = $patient->getPatient($item['patient_id'], "dossier,affiliations,user");
            $item['medecin'] = $patient->getMedecin($item['medecin_id']);
            $items[] = $item;
        }
        $examen_analyses['data']['data'] = $items;

        return json_encode($examen_analyses);
    }

    /**
     * @param $examen_analyse
     *
     * @return string
     */
    public function fetchExamenAnalyse($uuid): string
    {
        $patient = new PatientService;

        $examen_analyse = json_decode($this->request('GET', "{$this->path}/{$uuid}"));
        $examen_analyse->data->patient = $patient->getPatient($examen_analyse->data->patient_id, "dossier,affiliations,user");
        $examen_analyse->data->medecin = $patient->getMedecin($examen_analyse->data->medecin_id);
        $ligne_temps =  LigneDeTemps::find($examen_analyse->data->ligne_temps_id);
        $examen_analyse->data->ligne_temps =  !is_null($ligne_temps) ? $ligne_temps->load('motif:id,description,created_at', 'motifs:id,description,created_at') : null;
        $examen_analyse->data->pdf =  route('examen_analyses.print', $examen_analyse->data->uuid);

        return json_encode($examen_analyse);
    }

    public function getPatientBulletins($patient_id): string
    {
        $examen_analyses = json_decode($this->request('GET', "{$this->path}/patient/{$patient_id}/informations"));
        $examen_imageries = $examen_analyses->data->examen_imageries;
        $ordonnances = $examen_analyses->data->ordonnances;
        $examen_analyses = $examen_analyses->data->examen_analyses;
        $examen_analyse_items = [];
        foreach ($examen_analyses as $item) {
            $item->pdf = route('examen_analyses.print', $item->uuid);
            $examen_analyse_items[] = $item;
        }

        $examen_imagerie_items = [];
        foreach ($examen_imageries as $item) {
            $item->pdf = route('prescription_imageries.print', $item->uuid);
            $examen_imagerie_items[] = $item;
        }

        $ordonnance_items = [];
        foreach ($ordonnances as $item) {
            $teleconsultation = $item->teleconsultations[0];
            $item->pdf = route('ordonnances.teleconsultations.print',  $teleconsultation->uuid . '-' . $item->id);
            $ordonnance_items[] = $item;
        }

        return json_encode(["data" => ["examen_analyses" => $examen_analyse_items, "examen_imageries" => $examen_imagerie_items, "ordonnances" => $ordonnance_items]]);
        //return $this->request('GET', "{$this->path}/patient/{$patient_id}/informations");
    }

    public function getExamenAnalyses(Request $request, $patient_id): string
    {

        $patient = new PatientService;

        $examen_analyses = json_decode($this->request('GET', "{$this->path}/patient/{$patient_id}?search={$request->search}&page={$request->page}&page_size={$request->page_size}&patients={$request->patients}"));

        $items = [];
        foreach ($examen_analyses->data->data as $item) {
            $item->pdf = route('examen_analyses.print', $item->uuid);

            $item->patient = $patient->getPatient($item->patient_id, "dossier,affiliations,user");
            $item->medecin = $patient->getMedecin($item->medecin_id);
            $ligne_temps =  LigneDeTemps::find($item->ligne_temps_id);
            $item->ligne_temps =  !is_null($ligne_temps) ? $ligne_temps->load('motif:id,description,created_at', 'motifs:id,description,created_at') : null;
            $items[] = $item;
        }
        $examen_analyses->data->data = $items;

        return json_encode($examen_analyses);
    }

    /**
     * @param $data
     *
     * @return string
     */
    public function createExamenAnalyse($data): string
    {
        return $this->request('POST', "{$this->path}", $data);
    }

    /**
     * @param $examen_analyse
     * @param $data
     *
     * @return string
     */
    public function updateExamenAnalyse($examen_analyse, $data): string
    {
        return $this->request('PATCH', "{$this->path}/{$examen_analyse}", $data);
    }

    /**
     * @param $examen_analyse
     *
     * @return string
     */
    public function deleteExamenAnalyse($examen_analyse): string
    {
        return $this->request('DELETE', "{$this->path}/{$examen_analyse}");
    }
}
