<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\PersonnalErrors;
use App\Http\Requests\PatientMedecinControleRequest;
use App\Mail\updateSetting;
use App\Models\Affiliation;
use App\Models\DelaiOperation;
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
        DB::transaction(function () use($request) {
            foreach($request->medecin_control_id as $m){
                $medecin_referent = PatientMedecinControle::where(['medecin_control_id' => $m['id'], 'patient_id' => $request->patient_id])->first();
                $patientMedecin = null;
                if(is_null($medecin_referent)){
                    $patientMedecin = PatientMedecinControle::create([
                        "patient_id" => $request->patient_id,
                        "medecin_control_id" => $m['id'],
                        "creator" => Auth::id(),
                    ]);
                    //dd($patientMedecin);
                    $patient = Patient::where("user_id",$request->patient_id)->first();
                    $medecin = User::whereId($request->medecin_control_id)->first();
                    $message = "<@".$medecin->slack."> a été affecté au patient ".mb_strtoupper($patient->user->nom). " " .ucfirst($patient->user->prenom)." comme médecin referent";
                    // Send notification to affilié channel
                    $patientMedecin->setSlackChannel('affilie')->notify(new MedecinToPatient($message,null));
                    // Send notification to appel channel
                    $patientMedecin->setSlackChannel('appel')->notify(new MedecinToPatient($message,null));
                    $affiliation = Affiliation::where("patient_id",$request->patient_id)->latest()->first();
                    DelaiOperation::create(
                        [
                            "patient_id" => $request->patient_id,
                            "delai_operationable_id" => $patientMedecin->id,
                            "delai_operationable_type" => PatientMedecinControle::class,
                            "date_heure_prevue" => $affiliation->created_at,
                            "date_heure_effectif" => $patientMedecin->created_at,
                            "observation" => "RAS"
                        ]
                    );
                   
    
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
                $patientMedecin->setSlackChannel('affilie')
                ->notify(new MedecinToPatient($message,null));
                // Send notification to appel channel
                $patientMedecin->setSlackChannel('appel')
                ->notify(new MedecinToPatient($message,null));
            });
            
            return response()->json(['patientMedecin'=>$patientMedecin]);
        }else{
            return response()->json(['error'=>""]);
        }
    }
}
