<?php

namespace App\Services;

use App\Models\ActivitesControle;
use App\Models\ActivitesMedecinReferent;
use App\Models\Alerte;
use App\Models\Allergie;
use App\Models\Antecedent;
use App\Models\LigneDeTemps;
use App\Traits\RequestService;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

use function GuzzleHttp\json_decode;

class PrescriptionService
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

    public $allergie, $antecedent, $statut, $niveau_urgence, $user_id, $etablissement;

    /**
     * @var string
     */
    protected $path;

    public function __construct()
    {
        $this->baseUri = config('services.teleconsultations.base_uri');
        $this->secret = config('services.teleconsultations.secret');
        $this->path = "/api/v1/prescriptions";
        $this->allergie = new AllergieService;
        $this->antecedent = new AntecedentService;
        $this->statut = new StatutService;
        $this->niveau_urgence = new NiveauUrgenceService;
        $this->etablissement = new EtablissementService;
        if (\Auth::guard('api')->user()) {
            $this->user_id = \Auth::guard('api')->user()->id;
        }
    }

    /**
     * @return string
     */
    public function fetchPrescriptions(Request $request): string
    {
        $prescriptions = json_decode($this->request('GET', "{$this->path}?user_id={$this->user_id}&search={$request->search}&page={$request->page}&page_size={$request->page_size}&patients={$request->patients}"), true);

        $items = [];
        foreach ($prescriptions['data']['data'] as $item) {
            $patient = new PatientService;
            $item['patient'] = $patient->getPatient($item['patient_id'], "dossier,affiliations,user");
            $items[] = $item;
        }
        $prescriptions['data']['data'] = $items;

        return json_encode($prescriptions);
    }


    public function getEprescriptions(Request $request, $patient_id): string
    {

        $patient = new PatientService;

        $prescriptions = json_decode($this->request('GET', "{$this->path}/patient/{$patient_id}?search={$request->search}&page={$request->page}&page_size={$request->page_size}&patients={$request->patients}"));

        $items = [];
        foreach ($prescriptions->data->data as $item) {
            $item->pdf = route('prescriptions.print', $item->uuid);

            $item->patient = $patient->getPatient($item->patient_id, "dossier,affiliations,user");
            $item->medecin = $patient->getMedecin($item->medecin_id);
            $ligne_temps =  LigneDeTemps::find($item->ligne_temps_id);
            $item->ligne_temps =  !is_null($ligne_temps) ? $ligne_temps->load('motif:id,description,created_at', 'motifs:id,description,created_at') : null;
            $items[] = $item;
        }
        $prescriptions->data->data = $items;

        return json_encode($prescriptions);
    }

    /**
     * @param $prescription
     *
     * @return string
     */
    public function fetchPrescription($prescription): string
    {
        $patient = new PatientService;

        $prescription = json_decode($this->request('GET', "{$this->path}/{$prescription}"));
        $prescription->data->patient = $patient->getPatient($prescription->data->patient_id, "dossier,affiliations,user");
        $prescription->data->medecin = $patient->getMedecin($prescription->data->medecin_id);
        $prescription->data->pdf = route('prescriptions.print', $prescription->data->uuid);
        $ligne_temps =  LigneDeTemps::find($prescription->data->ligne_temps_id);
        $prescription->data->ligne_temps =  !is_null($ligne_temps) ? $ligne_temps->load('motif:id,description,created_at', 'motifs:id,description,created_at') : null;

        return json_encode($prescription);

        return $this->request('GET', "{$this->path}/{$prescription}");
    }

    /**
     * @param $data
     *
     * @return string
     */
    public function createPrescription($data): string
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
                "commentaire" => "Ajout d'une e-prescription pour le patient {$user->name}",
                "statut" => 0,
                "date_cloture" => Carbon::parse($prescription['data']['date_heure'])->format('Y-m-d')
            ]);
        }

        return json_encode($prescription);
    }

    /**
     * @param $prescription
     * @param $data
     *
     * @return string
     */
    public function updatePrescription($prescription, $data): string
    {
        return $this->request('PATCH', "{$this->path}/{$prescription}", $data);
    }

    /**
     * @param $prescription
     *
     * @return string
     */
    public function deletePrescription($prescription): string
    {
        return $this->request('DELETE', "{$this->path}/{$prescription}");
    }
}
