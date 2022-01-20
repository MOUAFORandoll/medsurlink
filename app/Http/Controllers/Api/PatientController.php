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
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Netpok\Database\Support\DeleteRestrictionException;

class PatientController extends Controller
{
    use PersonnalErrors;
    use SmsTrait;
    protected $table = 'patients';
        /**
     * @OA\Post(
     *      path="/v1/patients",
     *      operationId="getUserList",
     *      tags={"Patient"},
     * security={
     *  {"passport": {}},
     *   },
     *      summary="Get list of patient",
     *      description="Returns list of users",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     * @OA\Response(
     *      response=400,
     *      description="Bad Request"
     *   ),
     * @OA\Response(
     *      response=404,
     *      description="not found"
     *   ),
     *  )
     */
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $patients = Patient::with(['souscripteur','dossier','user','affiliations','financeurs.financable', 'medecinReferent.medecinControles.user'])->restrictUser()->get();
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
     * @param Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function medicasureStorePatient(Request $request)
    {
        $data = (object) $request->json()->all();
        Log::info(json_encode($data->original['cim']));
        $cim = (object) $data->original['cim'];
        $souscripteurUser = new User();
        $souscripteurUser->nom = $cim->nomSouscripteur;
        $souscripteurUser->prenom = $cim->prenomSouscripteur;
        $souscripteurUser->email = $cim->emailSouscripteur1;
        $souscripteurUser->nationalite = $cim->paysResidenceSouscripteur;
        $souscripteurUser->ville = $cim->villeResidenceSouscripteur;
        $souscripteurUser->telephone = $cim->telephoneSouscripeur1;
        $souscripteurUser->quartier = $cim->adresse_affilie;
        $souscripteurUser->code_postal = null;
        $souscripteurUser->adresse = null;
        $souscripteurUser->slack = null;
        $souscripteurUser->isMedicasure = 1;
        $souscripteurUser->isNotice = 1;
        $souscripteurUser->password = null;
        $souscripteurUser->decede = "non";
        $userResponse =  UserController::generatedUserFromMedicasure($souscripteurUser,'Souscripteur');
        if ($userResponse->status() == 419)
            return $userResponse;

        $userSouscripteur = $userResponse->getOriginalContent()['user'];
        $passwordSouscripteur = $userResponse->getOriginalContent()['password'];
        $userSouscripteur->assignRole('Souscripteur');

        //Creation du compte souscripteurs
        $age = 0;

        if (!is_null($cim->dateNaissanceSouscripteur)){
            $age = evaluateYearOfOld($cim->bornAroundSouscripteur);
        }

        $souscripteur = Souscripteur::create((array)$souscripteurUser + ['user_id' => $userSouscripteur->id,'age'=>$age]);
        Log::info("souscripteur créé");
        Log::info(json_encode($souscripteur));
        //defineAsAuthor("Souscripteur",$souscripteur->user_id,'create');

        //envoi des informations du compte utilisateurs par mail
        try{
            UserController::sendUserInformationViaMail($userSouscripteur,$passwordSouscripteur);
            //return response()->json(['souscripteur'=>$souscripteur]);
        }catch (\Swift_TransportException $transportException){
            $message = "L'operation à reussi mais le mail n'a pas ete envoye. Verifier votre connexion internet ou contacter l'administrateur";
            //return response()->json(['souscripteur'=>$souscripteur, "message"=>$message]);
        }

        //Creation de l'utilisateur dans la table user et génération du mot de passe
        $patientUser = new User();
        $patientUser->nom = $cim->nomAffilie;
        $patientUser->prenom = $cim->prenomAffilie;
        $patientUser->email = $cim->emailSouscripteur1;
        $patientUser->nationalite = null;
        $patientUser->ville = $cim->villeResidenceAffilie;
        $patientUser->telephone = $cim->telephoneAffilie1;
        $patientUser->quartier = null;
        $patientUser->pays = null;
        $patientUser->code_postal = null;
        $patientUser->adresse = null;
        $patientUser->slack = null;
        $patientUser->isMedicasure = 1;
        $patientUser->isNotice = 1;
        $patientUser->password = null;
        $patientUser->decede = "non";
        $patientUser->souscripteur_id = $souscripteur->id;
        $patientResponse =  UserController::generatedUserFromMedicasure($patientUser,"Patient");

        if($patientResponse->getOriginalContent()['user'] == null) {
            $this->revealError('nom', $patientResponse->getOriginalContent()['error']);
        }

        $patientUser = $patientResponse->getOriginalContent()['user'];
        $patientPassword = $patientResponse->getOriginalContent()['password'];
        $patientCode = $patientResponse->getOriginalContent()['code'];
        //Attribution du rôle patient
        $patientUser->assignRole('Patient');

        //Creation du compte patient

        $age = evaluateYearOfOld($cim->dateNaissanceAffilie);

        $patient = Patient::create((array)$patientUser + ['user_id' => $patientUser->id,'age'=>'44','date_de_naissance'=>'2020-08-10']);

        //Définition de la question secrete et de la reponse secrete
        //ReponseSecrete::create($cim->only(['question_id','reponse'])+['user_id' => $patientUser->id]);

        //Generation du dossier client
        $dossier = DossierMedicalController::genererDossier($patient->user_id);
        Suivi::create([
            'dossier_medical_id'=>$patient->dossier->id,
            'motifs'=>'Prise en charge initiale en attente',
            'categorie_id'=>'1'
        ]);
        //defineAsAuthor("Patient",$patient->user_id,'create',$patient->user_id);

        //Ajout du patient à l'etablissement selectionné
        $etablissements = [4];
        Auth::loginUsingId(1);
        foreach ($etablissements as $etablissementId){
            //Je verifie si ce patient n'est pas encore dans cette etablissement
            $nbre = EtablissementExercicePatient::where('etablissement_id','=',$etablissementId)->where('patient_id','=',$patient->user_id)->count();
            if ($nbre ==0){
                $etablissement = EtablissementExercice::find($etablissementId);

                $etablissement->patients()->attach($patient->user_id);

                //defineAsAuthor("Patient",$patient->user_id,'add to etablissement id'.$etablissement->id,$patient->user_id);
            }

        }
        //Envoi des informations patient par mail
        $patient = Patient::with(['dossier','affiliations'])->restrictUser()->whereSlug($patient->slug)->first();
        $identifiant = $patient->dossier->numero_dossier;
        try{
            //Envoi de sms
            $user = $patient->user;
//            $nom = (is_null($user->prenom) ? "" : ucfirst($user->prenom) ." ") . "". strtoupper( $user->nom);
            $nom = substr(strtoupper( $user->nom),0,9);
            $this->sendSMS($user->telephone,trans('sms.accountCreated',['nom'=>$nom,'password'=>$patientCode,'identifiant'=>$identifiant],'fr'));
            //!Envoi de sms

            UserController::sendUserPatientInformationViaMail($patientUser,$patientPassword);

            $patient = Patient::with('user','dossier')->where('user_id','=',$patient->user_id)->first();
            $souscripteur = Souscripteur::with('user')->where('user_id','=',$patient->souscripteur_id)->first();

            if (!is_null($souscripteur)){

                $user = $souscripteur->user;
                $this->sendSmsToUser($user,null,$identifiant);

                $mail = new PatientAffiliated($souscripteur,$patient);
                Mail::to($souscripteur->user->email)->send($mail);
            }


            return response()->json(['patient'=>$patient,"password"=>$patientPassword]);
        }catch (\Swift_TransportException $transportException){
            $message = "L'operation à reussi mais le mail n'a pas ete envoye. Verifier votre connexion internet ou contacter l'administrateur";
            return response()->json(['patient'=>$patient, "message"=>$message]);
        }
        Log::info('patient create from medicasure');

       //$this->store($cim);

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

        $patient = Patient::create($request->except(['code_postal','quartier']) + ['user_id' => $user->id,'age'=>$age]);

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
        $identifiant = $patient->dossier->numero_dossier;
        try{
            //Envoi de sms
            $user = $patient->user;
//            $nom = (is_null($user->prenom) ? "" : ucfirst($user->prenom) ." ") . "". strtoupper( $user->nom);
            $nom = substr(strtoupper( $user->nom),0,9);
            $this->sendSMS($user->telephone,trans('sms.accountCreated',['nom'=>$nom,'password'=>$code,'identifiant'=>$identifiant],'fr'));
            //!Envoi de sms

            UserController::sendUserPatientInformationViaMail($user,$password);

            $patient = Patient::with('user','dossier')->where('user_id','=',$patient->user_id)->first();
            $souscripteur = Souscripteur::with('user')->where('user_id','=',$patient->souscripteur_id)->first();

            if (!is_null($souscripteur)){

                $user = $souscripteur->user;
                $this->sendSmsToUser($user,null,$identifiant);

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

        /*$patient = Patient::with([
            'souscripteur.user',
            'user.questionSecrete',
            'affiliations',
            'etablissements',
            'financeurs.financable.user',
            'dossier',
        ])->restrictUser()->whereSlug($slug)->first();*/
        $patient = Patient::with([
            'souscripteur.user',
            'user.questionSecrete',
            'affiliations',
            'etablissements',
            'financeurs.financable.user',
            'dossier',
        ])->whereSlug($slug)->first();
        return response()->json(['patient'=>$patient]);
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $value
     * @return \Illuminate\Http\Response
     */

    public function specialList($value)
    {
        $result=[];
        $patients = Patient::with(['souscripteur','dossier', 'etablissements', 'user','affiliations','financeurs.financable', 'medecinReferent.medecinControles.user'])
                            ->restrictUser()
                            ->whereHas('user', function($q) use ($value) {$q->where('nom', 'like', '%' .$value.'%')
                                                                            ->orwhere('prenom', 'like', '%' .$value.'%')
                                                                            ->orwhere('email', 'like', '%' .$value.'%')
                                                                            ;})
                            ->orwhereHas('dossier', function($q) use ($value) {$q->where('numero_dossier', 'like', '%' .$value.'%');})
                            ->orwhere('age', 'like', '%' .$value.'%')
                            ->get();
        return $patients;
        // $patients = Patient::with(['souscripteur','dossier', 'etablissements', 'user','affiliations','financeurs.financable'])->where('age', '=', intval($value))->orWhereHas('user', function($q) use ($value){ $q->Where('nom', 'like', '%'.strtolower($value).'%'); $q->orWhere('prenom', 'like', '%'.strtolower($value).'%'); $q->orWhere('email', 'like', '%'.strtolower($value).'%');})->orWhereHas('dossier', function($q) use ($value){ $q->Where('numero_dossier', '=', intval($value)); })->restrictUser()->get();
        // return $patients;
        // foreach($patients as $p){

        //     if($p->user!=null){

        //         if(strpos(strtolower($p->user->nom),strtolower($value))!==false ||
        //     strpos(strtolower($p->user->prenom),strtolower($value))!==false ||
        //     strpos(strtolower(strval($p->dossier->numero_dossier)),strtolower($value))!==false ||
        //             strpos(strtolower(strval($p->age)),strtolower($value))!==false ||
        //     strpos(strtolower($p->user->email),strtolower($value))!==false) {
        //         // return $p;
        //         array_push($result,$p);
        //         // return $result;
        //     }


        //     }
        //     else{
        //         if(
        //             strpos(strtolower(strval($p->dossier->numero_dossier)),strtolower($value))!==false ||
        //             strpos(strtolower(strval($p->age)),strtolower($value))!==false)
        //             array_push($result,$p);
        //     }

        // }
        // return $result;

    }

    /**
     * Display the specified resource.
     *
     * @param  string  $value
     * @return \Illuminate\Http\Response
     */

    public function PatientsDoctor($value)
    {
        // return $value;
        $result=[];
        $patients = Patient::with(['souscripteur','dossier', 'etablissements', 'user','affiliations','financeurs.financable', 'medecinReferent.medecinControles.user'])->restrictUser()->get();

        // $patients = Patient::with(['souscripteur','dossier', 'etablissements', 'user','affiliations','financeurs.financable'])->where('age', '=', intval($value))->orWhereHas('user', function($q) use ($value){ $q->Where('nom', 'like', '%'.strtolower($value).'%'); $q->orWhere('prenom', 'like', '%'.strtolower($value).'%'); $q->orWhere('email', 'like', '%'.strtolower($value).'%');})->orWhereHas('dossier', function($q) use ($value){ $q->Where('numero_dossier', '=', intval($value)); })->restrictUser()->get();
        // return $patients;
        foreach($patients as $p){
            // if($p->user_id==629

                if(isset($p->medecinReferent)){
                    // return "true";
                    foreach($p->medecinReferent as $d){

                        if($d->medecinControles!=null && $d->medecinControles->user!=null){
                            if($d->medecinControles->user->id==$value){
                                array_push($result,$p);
                            }

                        }
                    }
                }
            // }
            // return "true";


        }
        return $result;

    }

    public function CountPatientsDoctor($value)
    {
        // return $value;
        $result=[];
        $patients = Patient::with(['souscripteur','dossier', 'etablissements', 'user','affiliations','financeurs.financable', 'medecinReferent.medecinControles.user'])->restrictUser()->get();

        // $patients = Patient::with(['souscripteur','dossier', 'etablissements', 'user','affiliations','financeurs.financable'])->where('age', '=', intval($value))->orWhereHas('user', function($q) use ($value){ $q->Where('nom', 'like', '%'.strtolower($value).'%'); $q->orWhere('prenom', 'like', '%'.strtolower($value).'%'); $q->orWhere('email', 'like', '%'.strtolower($value).'%');})->orWhereHas('dossier', function($q) use ($value){ $q->Where('numero_dossier', '=', intval($value)); })->restrictUser()->get();
        // return $patients;
        foreach($patients as $p){
            // if($p->user_id==629

                if(isset($p->medecinReferent)){
                    // return "true";
                    foreach($p->medecinReferent as $d){

                        if($d->medecinControles!=null && $d->medecinControles->user!=null){
                            if($d->medecinControles->user->id==$value){
                                array_push($result,$p);
                            }

                        }
                    }
                }
            // }
            // return "true";


        }
        return count($result);

    }

    /**
     * Display the specified resource.
     *
     * @param  string  $value
     * @return \Illuminate\Http\Response
     */

    public function FirstPatientsDoctor($value, $limit)
    {
        // return $value;
        $result=[];
        $patients = Patient::with(['souscripteur','dossier', 'etablissements', 'user','affiliations','financeurs.financable', 'medecinReferent.medecinControles.user'])->restrictUser()->get();

        // $patients = Patient::with(['souscripteur','dossier', 'etablissements', 'user','affiliations','financeurs.financable'])->where('age', '=', intval($value))->orWhereHas('user', function($q) use ($value){ $q->Where('nom', 'like', '%'.strtolower($value).'%'); $q->orWhere('prenom', 'like', '%'.strtolower($value).'%'); $q->orWhere('email', 'like', '%'.strtolower($value).'%');})->orWhereHas('dossier', function($q) use ($value){ $q->Where('numero_dossier', '=', intval($value)); })->restrictUser()->get();
        // return $patients;
        foreach($patients as $p){
            // if($p->user_id==629

                if(isset($p->medecinReferent)){
                    // return "true";
                    foreach($p->medecinReferent as $d){

                        if($d->medecinControles!=null && $d->medecinControles->user!=null){
                            if($d->medecinControles->user->id==$value){
                                array_push($result,$p);
                            }

                        }
                    }
                }
            // }
            // return "true";


        }
        return array_slice($result, 0, $limit);

    }

    public function NextPatientsDoctor($value, $limit, $page)
    {
        // return $value;
        $result=[];
        $patients = Patient::with(['souscripteur','dossier', 'etablissements', 'user','affiliations','financeurs.financable', 'medecinReferent.medecinControles.user'])->restrictUser()->get();

        // $patients = Patient::with(['souscripteur','dossier', 'etablissements', 'user','affiliations','financeurs.financable'])->where('age', '=', intval($value))->orWhereHas('user', function($q) use ($value){ $q->Where('nom', 'like', '%'.strtolower($value).'%'); $q->orWhere('prenom', 'like', '%'.strtolower($value).'%'); $q->orWhere('email', 'like', '%'.strtolower($value).'%');})->orWhereHas('dossier', function($q) use ($value){ $q->Where('numero_dossier', '=', intval($value)); })->restrictUser()->get();
        // return $patients;
        foreach($patients as $p){
            // if($p->user_id==629

                if(isset($p->medecinReferent)){
                    // return "true";
                    foreach($p->medecinReferent as $d){

                        if($d->medecinControles!=null && $d->medecinControles->user!=null){
                            if($d->medecinControles->user->id==$value){
                                array_push($result,$p);
                            }

                        }
                    }
                }
            // }
            // return "true";


        }
        return array_slice($result, ($page-1)*$limit, $limit);

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
            'question_id'=>'integer|nullable',
            'reponse'=>'nullable|string|min:3'
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
    public function getPatientWithMedecin()
    {
        $patients = Patient::with(['souscripteur','dossier','user','affiliations','medecinReferent.medecinControles.user'])->restrictUser()->whereHas('user', function($q) {$q->where('isMedicasure', '=', 1)->where('decede', '=', 'non');})->get();
        return response()->json(['patients'=>$patients]);
    }

    public function getFirstPatientWithMedecin($limit)
    {
        $patients = Patient::with(['souscripteur','dossier','user','affiliations','medecinReferent.medecinControles.user'])->restrictUser()->whereHas('user', function($q) {$q->where('isMedicasure', '=', 1)->where('decede', '=', 'non');})->take($limit)->get();
        return response()->json(['patients'=>$patients]);
    }

    public function getNextPatientWithMedecin($limit, $page)
    {
        $patients = Patient::with(['souscripteur','dossier','user','affiliations','medecinReferent.medecinControles.user'])->restrictUser()->whereHas('user', function($q) {$q->where('isMedicasure', '=', 1)->where('decede', '=', 'non');})->limit($limit)->offset(($page - 1) * $limit)->get();
        return response()->json(['patients'=>$patients]);
    }

    // public function get10PatientWithMedecin()
    // {
    //     $patients = Patient::with(['souscripteur','dossier','user','affiliations','medecinReferent.medecinControles.user'])->restrictUser()->take(10)->get();
    //     return response()->json(['patients'=>$patients]);
    // }

    // public function get15PatientWithMedecin()
    // {
    //     $patients = Patient::with(['souscripteur','dossier','user','affiliations','medecinReferent.medecinControles.user'])->restrictUser()->take(15)->get();
    //     return response()->json(['patients'=>$patients]);
    // }

    // public function get100PatientWithMedecin()
    // {
    //     $patients = Patient::with(['souscripteur','dossier','user','affiliations','medecinReferent.medecinControles.user'])->restrictUser()->take(100)->get();
    //     return response()->json(['patients'=>$patients]);
    // }

    public function getCountPatientWithMedecin()
    {
        $patients = Patient::with(['souscripteur','dossier','user','affiliations','medecinReferent.medecinControles.user'])->restrictUser()->whereHas('user', function($q) {$q->where('isMedicasure', '=', 1)->where('decede', '=', 'non');})->count();
        return response()->json(['count'=>$patients]);
    }
    public function searchPatients(Request $request)
    {
        $data = User::with(['patient','patient.dossier'])->where('nom', 'LIKE','%'.$request->keyword.'%')->get();
        return response()->json($data);
    }
}
