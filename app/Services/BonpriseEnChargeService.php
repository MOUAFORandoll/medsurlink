<?php

namespace App\Services;

use App\Models\ActivitesControle;
use App\Models\ActivitesMedecinReferent;
use App\Models\Affiliation;
use App\Models\DossierMedical;
use App\Models\EtablissementExercice;
use App\Models\LigneDeTemps;
use App\Traits\RequestService;
use App\User;
use Carbon\Carbon;
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
        if (\Auth::guard('api')->user()) {
            $this->user_id = \Auth::guard('api')->user()->id;
        }
    }

    /**
     * @return string
     */
    public function fetchBonPriseEnCharges(Request $request): string
    {
        $bon_prise_en_charges = json_decode($this->request('GET', "{$this->path}?user_id={$this->user_id}&search={$request->search}&page={$request->page}&page_size={$request->page_size}&patients={$request->patients}"), true);

        $items = [];
        foreach ($bon_prise_en_charges['data']['data'] as $item) {
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
    public function fetchBonPriseEnCharge($uuid): string
    {

        $patient = new PatientService;

        $bon_prise_en_charge = json_decode($this->request('GET', "{$this->path}/{$uuid}"));
        $bon_prise_en_charge->data->patient = $patient->getPatient($bon_prise_en_charge->data->patient_id, "dossier,affiliations,user");
        $bon_prise_en_charge->data->medecin = $patient->getMedecin($bon_prise_en_charge->data->medecin_id);
        $bon_prise_en_charge->data->pdf =  route('bon_prise_en_charges.print', $bon_prise_en_charge->data->uuid);
        $ligne_temps =  LigneDeTemps::find($bon_prise_en_charge->data->ligne_temps_id);

        $examen_analyse_items = [];
        $ordonnances = [];
        $examens_imageries = [];

        foreach ($bon_prise_en_charge->data->examens_analyses as $item) {
            $item->pdf = route('examen_analyses.print', $item->uuid);
            $examen_analyse_items[] = $item;
        }

        foreach ($bon_prise_en_charge->data->ordonnances as $item) {
            $item->pdf = route('ordonnances.print', ['bon_prise_en_charge_id' => $uuid, 'ordonnance_id' => $item->id]);
            $ordonnances[] = $item;
        }

        foreach ($bon_prise_en_charge->data->examens_imageries as $item) {
            $item->pdf = route('prescription_imageries.print', $item->uuid);
            $examens_imageries[] = $item;
        }

        $bon_prise_en_charge->data->examens_analyses = $examen_analyse_items;
        $bon_prise_en_charge->data->ordonnances = $ordonnances;
        $bon_prise_en_charge->data->examens_imageries = $examens_imageries;


        $bon_prise_en_charge->data->ligne_temps =  !is_null($ligne_temps) ? $ligne_temps->load('motif:id,description,created_at', 'motifs:id,description,created_at') : null;

        return json_encode($bon_prise_en_charge);
    }

    public function getBonPrisesEnCharges(Request $request, $patient_id): string
    {

        $patient = new PatientService;

        $bon_prise_en_charges = json_decode($this->request('GET', "{$this->path}/patient/{$patient_id}?search={$request->search}&page={$request->page}&page_size={$request->page_size}&patients={$request->patients}"));

        $items = [];
        foreach ($bon_prise_en_charges->data->data as $item) {
            $item->pdf = route('bon_prise_en_charges.print', $item->uuid);
            $item->patient = $patient->getPatient($item->patient_id, "dossier,affiliations,user");
            $item->medecin = $patient->getMedecin($item->medecin_id);
            $ligne_temps = LigneDeTemps::find($item->ligne_temps_id);
            $item->ligne_temps = !is_null($ligne_temps) ? $ligne_temps->load('motif:id,description,created_at', 'motifs:id,description,created_at') : null;
            $items[] = $item;
        }
        $bon_prise_en_charges->data->data = $items;

        return json_encode($bon_prise_en_charges);
    }

    /**
     * @param $data
     *
     * @return string
     */
    public function createBonPriseEnCharge($data): string
    {
        //return $this->request('POST', "{$this->path}", $data);

        $bon_prise_en_charge = json_decode($this->request('POST', "{$this->path}", $data), true);

        if(isset($bon_prise_en_charge['data']['patient_id'])){
            $affiliation =  LigneDeTemps::find($bon_prise_en_charge['data']['ligne_temps_id'])->affiliation;
            $etablissement = EtablissementExercice::where('name', "RÉSEAU MEDICASURE")->first();
            $user = User::find($bon_prise_en_charge['data']['patient_id']);
            $activity = ActivitesMedecinReferent::where('description_fr', "Etablissement d’un Bon de prise en charge / Ordonnance en externe pour un affilié")->first();
            $activite = ActivitesControle::create([
                "activite_id" => $activity->id,
                "patient_id" => $bon_prise_en_charge['data']['patient_id'],
                'etablissement_id' => $etablissement->id,
                'affiliation_id' => $affiliation ? $affiliation->id : null,
                'ligne_temps_id' => $bon_prise_en_charge['data']['ligne_temps_id'],
                "creator" => $this->user_id,
                "commentaire" => "Ajout d'un bon de prise en charge pour le patient {$user->name}",
                "statut" => 0,
                "date_cloture" => Carbon::parse($bon_prise_en_charge['data']['created_at'])->format('Y-m-d')
            ]);
            if(isset($bon_prise_en_charge['data']['rendez_vous'][0])){

                ActivitesControle::create([
                    "activite_id" => $activity->id,
                    "patient_id" => $bon_prise_en_charge['data']['patient_id'],
                    'etablissement_id' => $etablissement->id,
                    'affiliation_id' => $affiliation ? $affiliation->id : null,
                    'ligne_temps_id' => $bon_prise_en_charge['data']['ligne_temps_id'],
                    "creator" => $this->user_id,
                    "commentaire" => "Ajout d'un rendez-vous pour le patient {$user->name}",
                    "statut" => 0,
                    "date_cloture" => Carbon::parse($bon_prise_en_charge['data']['rendez_vous'][0]['date'])->format('Y-m-d')
                ]);
            }
        }
        

        return json_encode($bon_prise_en_charge);
    }

    /**
     * @param $bon_prise_en_charge
     * @param $data
     *
     * @return string
     */
    public function updateBonPriseEnCharge($bon_prise_en_charge, $data): string
    {
        return $this->request('PATCH', "{$this->path}/{$bon_prise_en_charge}", $data);
    }

    /**
     * @param $bon_prise_en_charge
     *
     * @return string
     */
    public function deleteBonPriseEnCharge($bon_prise_en_charge): string
    {
        return $this->request('DELETE', "{$this->path}/{$bon_prise_en_charge}");
    }


    /**
     * @param $patient_id
     *
     * @return string
     */
    public function fetchResultats($patient_id): string
    {
        $resultats = [];
        return json_encode($resultats);
    }
}
