<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\PersonnalErrors;
use App\Http\Requests\PatientMedecinControleRequest;
use App\Mail\updateSetting;
use App\Models\Patient;
use App\User;
use App\Models\PatientMedecinControle;
use App\Models\Souscripteur;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Notifications\MedecinToPatient;

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
        //
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
        foreach($request->medecin_control_id as $m){
            $patientMedecin = PatientMedecinControle::create([
                "patient_id" => $request->patient_id,
                "medecin_control_id" => $m['id'],
                "creator" => Auth::id(),
            ]);

            $patient = Patient::where("user_id",$request->patient_id)->first();
            $medecin = User::whereId($request->medecin_control_id)->first();
            $message = $medecin->nom." a été affecté au patient ".$patient->user->nom." comme médecin referent";
            $patientMedecin->notify(new MedecinToPatient($message,null));
        }
        return response()->json(['patient'=>$patientMedecin]);
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
    public function destroy($id)
    {
        //$this->validatedSlug($medecin,$this->table);
        //$request->validated();

        $patientMedecin = PatientMedecinControle::where("medecin_control_id",$id)->first();
        if($patientMedecin){
            $patientMedecin->delete();
            $patient = Patient::where("user_id",$patientMedecin->patient_id)->first();
            $medecin = User::whereId($patientMedecin->medecin_control_id)->first();
            $message = $medecin->nom." a été retiré au patient ".$patient->user->nom." comme médecin referent";
            $patientMedecin->notify(new MedecinToPatient($message,null));
            return response()->json(['patientMedecin'=>$patientMedecin]);
        }else{
            return response()->json(['error'=>"Erreur de suppression"]);
        }
    }
}
