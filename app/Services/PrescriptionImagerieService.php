<?php

namespace App\Services;

use App\Models\ActivitesControle;
use App\Models\ActivitesMedecinReferent;
use App\Models\LigneDeTemps;
use App\Traits\RequestService;
use App\User;
use Carbon\Carbon;
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
        if (\Auth::guard('api')->user()) {
            $this->user_id = \Auth::guard('api')->user()->id;
        }
    }

    /**
     * @return string
     */
    public function fetchPrescriptionImageries(Request $request): string
    {
        $prescription_imageries = json_decode($this->request('GET', "{$this->path}?user_id={$this->user_id}&search={$request->search}&page={$request->page}&page_size={$request->page_size}&patients={$request->patients}"), true);

        $items = [];
        foreach ($prescription_imageries['data']['data'] as $item) {
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
    public function fetchPrescriptionImagerie($uuid): string
    {

        $patient = new PatientService;

        $prescription_imagerie = json_decode($this->request('GET', "{$this->path}/{$uuid}"));
        $prescription_imagerie->data->patient = $patient->getPatient($prescription_imagerie->data->patient_id, "dossier,affiliations,user");
        $prescription_imagerie->data->medecin = $patient->getMedecin($prescription_imagerie->data->medecin_id);
        $prescription_imagerie->data->ligne_de_temps = LigneDeTemps::find($prescription_imagerie->data->ligne_temps_id);
        $prescription_imagerie->data->niveau_urgence = json_decode($this->niveau_urgence->fetchNiveauUrgence($prescription_imagerie->data->niveau_urgence_id), true)['data'];
        $prescription_imagerie->data->pdf =  route('prescription_imageries.print', $prescription_imagerie->data->uuid);

        return json_encode($prescription_imagerie);
    }

    public function getExamenImageries(Request $request, $patient_id): string
    {

        $patient = new PatientService;

        $prescription_imageries = json_decode($this->request('GET', "{$this->path}/patient/{$patient_id}?search={$request->search}&page={$request->page}&page_size={$request->page_size}&patients={$request->patients}"));

        $items = [];
        foreach ($prescription_imageries->data->data as $item) {
            $item->pdf = route('prescription_imageries.print', $item->uuid);

            $item->patient = $patient->getPatient($item->patient_id, "dossier,affiliations,user");
            $item->medecin = $patient->getMedecin($item->medecin_id);
            $ligne_temps =  LigneDeTemps::find($item->ligne_temps_id);
            $item->ligne_temps =  !is_null($ligne_temps) ? $ligne_temps->load('motif:id,description,created_at', 'motifs:id,description,created_at') : null;
            $items[] = $item;
        }
        $prescription_imageries->data->data = $items;

        return json_encode($prescription_imageries);
    }

    /**
     * @param $data
     *
     * @return string
     */
    public function createPrescriptionImagerie($data): string
    {
        //return $this->request('POST', "{$this->path}", $data);

        $prescription = json_decode($this->request('POST', "{$this->path}", $data), true);

        if(isset($prescription['data']['patient_id'])){
            $affiliation =  LigneDeTemps::find($prescription['data']['ligne_temps_id'])->affiliation;
            $user = User::find($prescription['data']['patient_id']);
            $activity = ActivitesMedecinReferent::where('description_fr', "Etablissement d’un Bon de prise en charge / Ordonnance en externe pour un affilié")->first();
            $activite = ActivitesControle::create([
                "activite_id" => $activity->id,
                "patient_id" => $prescription['data']['patient_id'],
                'etablissement_id' => $prescription['data']['etablissements'][0]['id'],
                'affiliation_id' => $affiliation ? $affiliation->id : null,
                'ligne_temps_id' => $prescription['data']['ligne_temps_id'],
                "creator" => $this->user_id,
                "commentaire" => "Ajout d'une prescription imagerie pour le patient {$user->name}",
                "statut" => 0,
                "date_cloture" => Carbon::parse($prescription['data']['date_heure'])->format('Y-m-d')
            ]);
        }

        return json_encode($prescription);
    }

    /**
     * @param $prescription_imagerie
     * @param $data
     *
     * @return string
     */
    public function updatePrescriptionImagerie($prescription_imagerie, $data): string
    {
        return $this->request('PATCH', "{$this->path}/{$prescription_imagerie}", $data);
    }

    /**
     * @param $prescription_imagerie
     *
     * @return string
     */
    public function deletePrescriptionImagerie($prescription_imagerie): string
    {
        return $this->request('DELETE', "{$this->path}/{$prescription_imagerie}");
    }
}
