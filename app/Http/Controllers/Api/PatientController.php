<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Traits\PersonnalErrors;
use App\Http\Requests\patientStoreRequest;
use App\Http\Requests\PatientUpdateRequest;
use App\Http\Requests\UserStoreRequest;
use App\Mail\PatientAffiliated;
use App\Mail\updateSetting;
use App\Models\DossierMedical;
use App\Models\EtablissementExercice;
use App\Models\EtablissementExercicePatient;
use App\Models\Patient;
use App\Models\ReponseSecrete;
use App\Models\Souscripteur;
use App\Models\Suivi;
use App\Traits\SmsTrait;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Netpok\Database\Support\DeleteRestrictionException;

class PatientController extends Controller
{
    use PersonnalErrors;
    use SmsTrait;
    protected $table = 'patients';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $patients = Patient::with(['souscripteur','dossier','user','affiliations','financeurs.financable'])->restrictUser()->get();
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

        if($userResponse->getOriginalContent()['user'] == null) {
            $this->revealError('nom', $userResponse->getOriginalContent()['error']);
        }

        $user = $userResponse->getOriginalContent()['user'];
        $password = $userResponse->getOriginalContent()['password'];
        $code = $userResponse->getOriginalContent()['code'];
        //Attribution du rôle patient
        $user->assignRole('Patient');

        //Creation du compte patient

        $age = evaluateYearOfOld($request->date_de_naissance);

        $patient = Patient::create($request->except(['code_postal','quartier','question_id','reponse']) + ['user_id' => $user->id,'age'=>$age]);

        //Définition de la question secrete et de la reponse secrete
        ReponseSecrete::create($request->only(['question_id','reponse'])+['user_id' => $user->id]);

        //Generation du dossier client
        $dossier = DossierMedicalController::genererDossier($patient->user_id);
        Suivi::create([
            'dossier_medical_id'=>$patient->dossier->id,
            'motifs'=>'Prise en charge initiale en attente',
            'categorie_id'=>'1'
        ]);
        defineAsAuthor("Patient",$patient->user_id,'create',$patient->user_id);

        //Ajout du patient à l'etablissement selectionné
        $etablissements = $request->get('etablissement_id');
        foreach ($etablissements as $etablissementId){
            //Je verifie si ce patient n'est pas encore dans cette etablissement
            $nbre = EtablissementExercicePatient::where('etablissement_id','=',$etablissementId)->where('patient_id','=',$patient->user_id)->count();
            if ($nbre ==0){
                $etablissement = EtablissementExercice::find($etablissementId);

                $etablissement->patients()->attach($patient->user_id);

                defineAsAuthor("Patient",$patient->user_id,'add to etablissement id'.$etablissement->id,$patient->user_id);
            }

        }


        //Envoi des informations patient par mail
        $patient = Patient::with(['dossier','affiliations'])->restrictUser()->whereSlug($patient->slug)->first();
        try{
            //Envoi de sms
            $user = $patient->user;
//            $nom = (is_null($user->prenom) ? "" : ucfirst($user->prenom) ." ") . "". strtoupper( $user->nom);
            $nom = substr(strtoupper( $user->nom),0,9);
            $this->sendSMS($user->telephone,trans('sms.accountCreated',['nom'=>$nom,'password'=>$code],'fr'));
            //!Envoi de sms

            UserController::sendUserPatientInformationViaMail($user,$password);

            $patient = Patient::with('user','dossier')->where('user_id','=',$patient->user_id)->first();
            $souscripteur = Souscripteur::with('user')->where('user_id','=',$patient->souscripteur_id)->first();
            if (!is_null($souscripteur)){

                $user = $souscripteur->user;
                $this->sendSmsToUser($user);

                $mail = new PatientAffiliated($souscripteur,$patient);
                Mail::to($souscripteur->user->email)->send($mail);
            }


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

        $patient = Patient::with([
            'souscripteur.user',
            'user.questionSecrete',
            'affiliations',
            'etablissements',
            'financeurs.financable.user',
            'dossier',
        ])->restrictUser()->whereSlug($slug)->first();

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

        $response = UserController::updatePersonalInformation($request->except('patient','souscripteur_id','sexe','question_id','reponse'),$patient->user->slug);

        if($response->getOriginalContent()['user'] == null) {
            $this->revealError('nom', $response->getOriginalContent()['error']);
        }

        $age = evaluateYearOfOld($request->date_de_naissance);

        Patient::whereSlug($slug)->update($request->only([
                "user_id",
                "souscripteur_id",
                "sexe",
                "date_de_naissance",
                "age",
                "nom_contact",
                "tel_contact",
                "lien_contact",
            ])+['age'=>$age]);

        $patient = Patient::with(['souscripteur','user','affiliations'])->restrictUser()->whereSlug($slug)->first();

        //Mise à jour de la question et la reponse secrete
        if (is_null($patient->user->questionSecrete) || $patient->user->questionSecrete->isEmpty ){
            ReponseSecrete::create($request->only(['question_id','reponse'])+['user_id' => $patient->user->id]);
        }else{
            ReponseSecrete::where('user_id','=',$patient->user_id)->update($request->only(['question_id','reponse']));
        }

        try{

            if (!is_null($patient->user->email)){
                $mail = new updateSetting($patient->user);
                Mail::to($patient->user->email)->send($mail);
            }

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
            $patient = Patient::with(['souscripteur','user','affiliations'])->restrictUser()->whereSlug($slug)->first();
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

    /**
     * Fonction permettant de générer un nouveau mot de passe pour un numero de dossier précis
     * @param Request $request
     */
    public function resetPassword(Request $request){
        $request->validate([
            'numero_dossier'=>"required|string|exists:dossier_medicals,numero_dossier",
            'date_de_naissance'=>"required|date",
            'telephone'=>'required|string|min:9',
            'question_id'=>'required|integer|exists:questions,id',
            'reponse'=>'required|string|min:3'
        ]);

        $dossier = DossierMedical::where('numero_dossier',$request->get('numero_dossier'))->first();
        $user = $dossier->patient->user;
        $questionSecrete = $user->questionSecrete;
        //Verification du numero de telephone
        if ($user->telephone != $request->get('telephone')){
            $this->revealError('telephone','Phone invalid');
        }
        //Verification de la question de securite
        if ($questionSecrete->question_id != $request->get('question_id')){
            $this->revealError('question_id','Secret question or answer invalid');
        }
        //Verification de la reponse de securite
        if (strtoupper($questionSecrete->reponse) != strtoupper($request->get('reponse'))){
            $this->revealError('question_id','Secret question or answer invalid');
        }

        $password = str_random(10);
        $code="";
        $date_naissance = Carbon::parse($request->get('date_de_naissance'))->year;
        $code = substr($password,0,5);
        $password = $date_naissance.$code;

//        $nom = (is_null($user->prenom) ? "" : ucfirst($user->prenom) ." ") . "". strtoupper( $user->nom);
        $nom = substr(strtoupper( $user->nom),0,20);
        $user->password = bcrypt($password);
        $user->save();
        if ($user->decede == 'non') {
            sendSMS($request->get('telephone'), trans('sms.accountSecurityUpdated', ['nom' => $nom, 'password' => $code], 'fr'));
        }
        return response()->json(['message'=>'Sms envoyé avec succès']);
    }

    public function decede(Request $request,$slug){
        $this->validatedSlug($slug,$this->table);
        $patient = Patient::with(['souscripteur','user','affiliations'])->restrictUser()->whereSlug($slug)->first();
        $user = User::whereId($patient->user_id)->first();

        $user->decede = $request->get('decede');
        $user->save();
        $patient = Patient::with(['souscripteur','user','affiliations'])->restrictUser()->whereSlug($slug)->first();
        return response()->json(['patient'=>$patient]);
    }
}
