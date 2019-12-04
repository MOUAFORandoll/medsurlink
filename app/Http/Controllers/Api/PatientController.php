<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Traits\PersonnalErrors;
use App\Http\Requests\patientStoreRequest;
use App\Http\Requests\PatientUpdateRequest;
use App\Http\Requests\UserStoreRequest;
use App\Mail\PatientAffiliated;
use App\Mail\updateSetting;
use App\Models\Patient;
use App\Models\Souscripteur;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Netpok\Database\Support\DeleteRestrictionException;

class PatientController extends Controller
{
    use PersonnalErrors;
    protected $table = 'patients';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $patients = Patient::with(['souscripteur','dossier','user','affiliations','etablissements'])->restrictUser()->get();
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
     * @param patientStoreRequest $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(patientStoreRequest $request)
    {

        //Creation de l'utilisateur dans la table user et génération du mot de passe
        $userResponse =  UserController::generatedUser($request,"Patient");

        $user = $userResponse->getOriginalContent()['user'];
        $password = $userResponse->getOriginalContent()['password'];

        //Attribution du rôle patient
        $user->assignRole('Patient');

        //Creation du compte patient
        $age = evaluateYearOfOld($request->date_de_naissance);
        $patient = Patient::create($request->validated() + ['user_id' => $user->id,'age'=>$age]);

        //Generation du dossier client
        $dossier = DossierMedicalController::genererDossier($patient->user_id);
        defineAsAuthor("Patient",$patient->user_id,'create',$patient->user_id);

        //Envoi des informations patient par mail
        $patient = Patient::with(['dossier','affiliations'])->restrictUser()->whereSlug($patient->slug)->first();
        try{
            UserController::sendUserPatientInformationViaMail($user,$password);

            $patient = Patient::with('user')->where('user_id','=',$patient->user_id)->first();
            $souscripteur = Souscripteur::with('user')->where('user_id','=',$patient->souscripteur_id)->first();

            $mail = new PatientAffiliated($souscripteur,$patient);
            Mail::to($souscripteur->user->email)->send($mail);

            return response()->json(['patient'=>$patient,"password"=>$password]);
        }catch (\Swift_TransportException $transportException){
            $message = "L'operation à reussi mais le mail n'a pas ete envoye. Verifier votre connexion internet ou contacter l'administrateur";
            return response()->json(['patient'=>$patient, "message"=>$message]);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $this->validatedSlug($slug,$this->table);

        $patient = Patient::with(['souscripteur','user','affiliations','etablissements'])->restrictUser()->whereSlug($slug)->first();

        return response()->json(['patient'=>$patient]);
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
     * @param PatientUpdateRequest $request
     * @param $slug
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(PatientUpdateRequest $request, $slug)
    {
        $this->validatedSlug($slug,$this->table);

        $patient= Patient::with('user')->whereSlug($slug)->first();

        UserController::updatePersonalInformation($request->except('date_de_naissance','patient','souscripteur_id','sexe'),$patient->user->slug);

        $age = evaluateYearOfOld($request->date_de_naissance);
        Patient::whereSlug($slug)->update($request->validated()+['age'=>$age]);

        $patient = Patient::with(['souscripteur','user','affiliations','etablissements'])->restrictUser()->whereSlug($slug)->first();

        try{
            $mail = new updateSetting($patient->user);

            Mail::to($patient->user->email)->send($mail);

        }catch (\Swift_TransportException $transportException){
            $message = "L'operation à reussi mais le mail n'a pas ete envoye. Verifier votre connexion internet ou contacter l'administrateur";
            return response()->json(['patient'=>$patient, "message"=>$message]);

        }
        return response()->json(['patient'=>$patient]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $slug
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function destroy($slug)
    {
        $this->validatedSlug($slug,$this->table);

        try{
            $patient = Patient::with(['souscripteur','user','affiliations','etablissements'])->restrictUser()->whereSlug($slug)->first();
            $dossier = $patient->dossier;
            if (!is_null($dossier)){
                $dossier->delete();
                defineAsAuthor("DossierMedical",$dossier->id,'delete',$patient->user_id);
            }
            $patient->delete();
            defineAsAuthor("Patient",$patient->user_id,'delete',$patient->user_id);
            return response()->json(['patient'=>$patient]);

        }catch (DeleteRestrictionException $deleteRestrictionException){
            $this->revealError('deletingError',$deleteRestrictionException->getMessage());
        }
    }

}
