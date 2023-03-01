<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\PersonnalErrors;
use App\Http\Requests\PatientMedecinControleRequest;
use App\Mail\updateSetting;
use App\Models\Affiliation;
use App\Models\DelaiOperation;
use App\Models\DossierMedical;
use App\Models\MedecinControle;
use App\Models\Patient;
use App\User;
use App\Models\PatientMedecinControle;
use App\Models\Souscripteur;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Notifications\MedecinToPatient;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PatientMedecinController extends Controller
{
    use PersonnalErrors;
    protected $table = 'patient_medecin_controles';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $patients = PatientMedecinControle::with(['medecinControles.user','patients.user','patients.dossier'])->get();
        return response()->json(['patients'=>$patients]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PatientMedecinControleRequest $request)
    {
        $request->validated();
        $patientMedecin = "";
        $dossier = DossierMedical::where('patient_id', $request->patient_id)->latest()->first();
        $affiliation = Affiliation::where("patient_id",$request->patient_id)->latest()->first();
        DB::transaction(function () use($request, $dossier, $affiliation) {
            foreach($request->medecin_control_id as $m){
                $medecin_referent = PatientMedecinControle::where(['medecin_control_id' => $m['id'], 'patient_id' => $request->patient_id])->first();
                $patientMedecin = null;
                if(is_null($medecin_referent)){
                    $patientMedecin = PatientMedecinControle::create([
                        "patient_id" => $request->patient_id,
                        "medecin_control_id" => $m['id'],
                        "creator" => Auth::id(),
                    ]);

                    $patient = Patient::where("user_id",$request->patient_id)->first();
                    $medecin = User::whereId($request->medecin_control_id)->first();
                    $message = "<@".$medecin->slack."> a été affecté au patient ".mb_strtoupper($patient->user->nom). " " .ucfirst($patient->user->prenom)." comme médecin referent";

                    $this->sendToSlack($patientMedecin, $message);
                    if(!is_null($affiliation)){
                        DelaiOperation::create(
                            [
                                "patient_id" => $request->patient_id,
                                "delai_operationable_id" => $patientMedecin->id,
                                "delai_operationable_type" => PatientMedecinControle::class,
                                "date_heure_prevue" => $affiliation->updated_at,
                                "date_heure_effectif" => $patientMedecin->created_at,
                                "observation" => "RAS"
                            ]
                        );
                    }else{
                        DelaiOperation::create(
                            [
                                "patient_id" => $request->patient_id,
                                "delai_operationable_id" => $patientMedecin->id,
                                "delai_operationable_type" => PatientMedecinControle::class,
                                "date_heure_prevue" => $dossier->updated_at,
                                "date_heure_effectif" => $patientMedecin->created_at,
                                "observation" => "RAS"
                            ]
                        );
                    }
                }
            }
        });
        
        return response()->json(['patient' => $patientMedecin]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function retirer(Request $request){

        $patient = PatientMedecinControle::find($request->get('medecin_control_id'));

        return response()->json(['patient'=>$patient]);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }
    /**
     *  Transfère  des patients d'un médécin controle à une autre
     */
    public function transfertPatientFromOneMedecinToAnother(Request $request){

        $this->validate($request, [
            'ancien_medecin_referent' => 'required|numeric',
            'nouveau_medecin_referent' => 'required|numeric'
        ]); 

        if(is_null($request->patients)){
            $patient_medecin_controles = PatientMedecinControle::where('medecin_control_id', $request->ancien_medecin_referent)->get();
            foreach($patient_medecin_controles as $patient_medecin_controle){
                $patient_medecin_controle->medecin_control_id = $request->nouveau_medecin_referent;
                $patient_medecin_controle->save();
            }
        }else{
            $patient_medecin_controles = PatientMedecinControle::where('medecin_control_id', $request->ancien_medecin_referent)->whereIn('patient_id', $request->patients)->get();
            foreach($patient_medecin_controles as $patient_medecin_controle){
                $patient_medecin_controle->medecin_control_id = $request->nouveau_medecin_referent;
                $patient_medecin_controle->save();
            }
        }
        $ancien_medecin_referent = User::whereId($request->ancien_medecin_referent)->first();
        $medecin_patients = $patient_medecin_controles->count();
        $nouveau_medecin_referent = User::whereId($request->nouveau_medecin_referent)->first();
        if($medecin_patients > 0){
            $medecin_patients = $medecin_patients == 1 ? "1 patient" : "2 patients";
            $message = "<@".$nouveau_medecin_referent->slack."> a reçu un transfert de ".$medecin_patients." précédement suivie par <@".$ancien_medecin_referent->slack."> comme médecin referent";
            // Send notification to affilié channel
             $nouveau_medecin_referent->setSlackChannel('affilie')->notify(new MedecinToPatient($message,null));
            // Send notification to appel channel
             $nouveau_medecin_referent->setSlackChannel('appel')->notify(new MedecinToPatient($message,null));
        }
        return response()->json(['nouveau_medecin_referent' => $nouveau_medecin_referent]);
    }


    /**
     * Liste des patiens suivie par un médécin controle
     */
    public function getPatients($medecin_control_id){
        $patients = MedecinControle::find($medecin_control_id)->patients()->with('user')->get();
        $patient_retour = collect();
        foreach($patients as $patient){
            $item = new \stdClass();
            $item->id = $patient->user_id;
            $item->nom = ucfirst($patient->user->prenom).' '.mb_strtoupper($patient->user->nom);
            $patient_retour->push($item);
        }
        
        $patient_retour = $patient_retour->unique();
        $patient_retour = $patient_retour->sortBy('nom');
        $patient_retour = $patient_retour->values()->all();

        return response()->json(['patients' => $patient_retour]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $identifiants = explode("|", $id);
        $medecin_control_id = $identifiants[0];
        $patient_id = $identifiants[1];
        //$this->validatedSlug($medecin,$this->table);
        //$request->validated();

        $patientMedecin = PatientMedecinControle::where(["medecin_control_id" => $medecin_control_id, "patient_id" => $patient_id])->first();

        if($patientMedecin){
            DB::transaction(function () use($patientMedecin, $patient_id) {
                $patientMedecin->delete();
                $patient = Patient::where("user_id", $patient_id)->first();
                // dd($patient);
                $medecin = User::whereId($patientMedecin->medecin_control_id)->first();
                $message = "<@".$medecin->slack."> a été retiré au patient ".mb_strtoupper($patient->user->nom). " " .ucfirst($patient->user->prenom)." comme médecin referent";
                // Send notification to affilié channel
                $this->sendToSlack($patientMedecin, $message);
            });

            return response()->json(['patientMedecin'=>$patientMedecin]);
        }else{
            return response()->json(['error'=>""]);
        }
    }

    public function sendToSlack($patientMedecin, $message){

        $patientMedecin->getAffilieSlackChannel()->notify(new MedecinToPatient($message,null));
                    // Send notification to appel channel
        $patientMedecin->getAppelSlackChannel()->notify(new MedecinToPatient($message,null));


       /*  $patientMedecin->setSlackChannel('affilie')->notify(new MedecinToPatient($message,null));
            // Send notification to appel channel
        $patientMedecin->setSlackChannel('appel')->notify(new MedecinToPatient($message,null)); */
    }
}
