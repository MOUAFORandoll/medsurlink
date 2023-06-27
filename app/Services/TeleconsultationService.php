<?php

namespace App\Services;

use App\Models\ActivitesControle;
use App\Models\ActivitesMedecinReferent;
use App\Models\Affiliation;
use App\Models\Alerte;
use App\Models\Allergie;
use App\Models\Antecedent;
use App\Models\DossierMedical;
use App\Models\LigneDeTemps;
use App\Traits\RequestService;
use App\User;
use Carbon\Carbon;
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
    
    public $allergie, $antecedent, $statut, $niveau_urgence, $user_id;

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
        $this->statut = new StatutService;
        $this->niveau_urgence = new NiveauUrgenceService;
        if(\Auth::guard('api')->user()){
            $this->user_id = \Auth::guard('api')->user()->id;
        }

    }

    /**
     * @return string
     */
    public function fetchTeleconsultations(Request $request) : string
    {
        $teleconsultations = json_decode($this->request('GET', "{$this->path}?user_id={$this->user_id}&search={$request->search}&page={$request->page}&page_size={$request->page_size}&patients={$request->patients}"), true);

        $items = [];
        foreach($teleconsultations['data']['data'] as $item){
            $patient = new PatientService;
            $alerte = new AlerteService;
            $video = new BigBlueButtonService;
            $item['patient'] = $patient->getPatient($item['patient_id'], "dossier,affiliations,user");
            $item['alerte'] = $alerte->getAlerte($item['id']);
            $items[] = $item;
        }
        $teleconsultations['data']['data'] = $items;

        return json_encode($teleconsultations);
    }
    /**
     *  recupération des téléconsultations d'un patient spécifique
     */
    public function getTeleconsultations($patient_id, Request $request) : string
    {
        $teleconsultations = json_decode($this->request('GET', "{$this->path}/patient/{$patient_id}?user_id={$patient_id}&search={$request->search}&page={$request->page}&page_size={$request->page_size}"), true);

        $items = [];
        foreach($teleconsultations['data']['data'] as $item){
            $patient = new PatientService;
            $alerte = new AlerteService;
            $video = new BigBlueButtonService;
            $item['patient'] = $patient->getPatient($item['patient_id'], "dossier,affiliations,user");
            $item['medecin'] = $patient->getMedecin($item['creator']);
            $item['alerte'] = $alerte->getAlerte($item['id']);
            $item['pdf'] =  route('teleconsultations.print', $item['uuid']);
            //$item['url'] = $video->getRecordings($item['patient_id'], $item['creator'], $item['created_at']);
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
    public function fetchTeleconsultation($uuid) : string
    {
        $patient = new PatientService;
        $alerte = new AlerteService;
        $video = new BigBlueButtonService;

        $teleconsultation = json_decode($this->request('GET', "{$this->path}/{$uuid}"));
        $teleconsultation->data->patient = $patient->getPatient($teleconsultation->data->patient_id, "dossier,affiliations,user");
        $teleconsultation->data->alerte = $alerte->getAlerte($teleconsultation->data->id);
        $teleconsultation->data->pdf =  route('teleconsultations.print', $teleconsultation->data->uuid);
        $teleconsultation->data->url = $video->getRecordings($teleconsultation->data->patient_id, $teleconsultation->data->creator, $teleconsultation->data->created_at);

        return json_encode($teleconsultation);
    }

    public function fetchAlerte($medecin_id, $patient_id){
        $alerte = Alerte::where(['patient_id' => $patient_id, 'medecin_id' => $medecin_id, 'statut_id' => 2, 'teleconsultation_id' => NULL])->latest()->first();
        if(!is_null($alerte)){
            $alerte = $alerte->load('creator:id,nom,prenom,email,telephone', 'patient:id,nom,prenom,email,telephone,slug', 'patient.dossier:patient_id,slug', 'patient.patient:user_id,sexe,date_de_naissance,slug', 'medecin:id,nom,prenom,email,telephone,slug');
            $alerte->statut = json_decode($this->statut->fetchStatut($alerte->statut_id), true)['data'];
            $alerte->niveau_urgence = json_decode($this->niveau_urgence->fetchNiveauUrgence($alerte->niveau_urgence_id), true)['data'];
        }
        return $alerte ?? null;
    }

    public function fetchAllergies($patient_id){
        $allergies_courant = Allergie::whereHas('dossiers', function ($query) use ($patient_id) {
            $query->where('patient_id', $patient_id);
        })->latest()->get();

        $allergies_back = json_decode($this->allergie->fetchPatientAllergie($patient_id));
        $allergies_back = collect($allergies_back->data);
        $allergies = $allergies_back->merge($allergies_courant);
        $allergies = $allergies->toArray();

        return $allergies;
    }

    public function printTeleconsultation($teleconsultation_id){
        return route('teleconsultations.print', $teleconsultation_id);
    }

    public function fetchAntecedents($patient_id){
        $antecedents_courant = Antecedent::whereHas('dossier', function ($query) use ($patient_id) {
            $query->where('patient_id', $patient_id);
        })->latest()->get();

        $antecedents_back = json_decode($this->antecedent->fetchPatientAntecedent($patient_id));
        $antecedents_back = collect($antecedents_back->data);
        $antecedents = $antecedents_back->merge($antecedents_courant);
        $antecedents = $antecedents->toArray();

        return $antecedents;
    }

    /**
     * @param $data
     *
     * @return string
     */
    public function createTeleconsultation($data) : string
    {
        $teleconsultation = json_decode($this->request('POST', "{$this->path}", $data), true);

        if(isset($teleconsultation['data']['patient_id'])){
            $dossier = DossierMedical::where("patient_id", $teleconsultation['data']['patient_id'])->first();
            $affiliation = Affiliation::where("patient_id", $teleconsultation['data']['patient_id'])->latest()->first();
            $ligne_temps = LigneDeTemps::where('dossier_medical_id', $dossier->id)->latest()->first();
            $user = User::find($teleconsultation['data']['patient_id']);
            $activity = ActivitesMedecinReferent::where('description_fr', "Consultation générale préventive")->first();
            $activite = ActivitesControle::create([
                "activite_id" => $activity->id,
                "patient_id" => $teleconsultation['data']['patient_id'],
                'etablissement_id' => $teleconsultation['data']['etablissements'][0]['id'],
                'affiliation_id' => $affiliation ? $affiliation->id : null,
                'ligne_temps_id' => $ligne_temps ? $ligne_temps->id : null,
                "creator" => $this->user_id,
                "commentaire" => "Ajout d'une téléconsultation pour le patient {$user->name}",
                "statut" => 0,
                "date_cloture" => Carbon::parse($teleconsultation['data']['date_heure'])->format('Y-m-d')
            ]);
        }

        return json_encode($teleconsultation);
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
