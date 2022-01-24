<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\PersonnalErrors;
use App\Http\Requests\ConsutationMedecineRequest;
use App\Models\Antecedent;
use App\Models\Conclusion;
use App\Models\ConsultationMedecineGenerale;
use App\Models\ConsultationMotifs;
use App\Models\Contributeurs;
use App\Models\EtablissementExercice;
use App\Models\EtablissementExercicePatient;
use App\Models\Motif;
use App\Models\ConsultationExamenValidation;
use App\Models\ParametreCommun;
use App\Models\Patient;
use App\Models\RendezVous;
use App\Models\Traitement;
use App\Models\TraitementActuel;
use App\Traits\DossierTrait;
use App\Traits\SmsTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Netpok\Database\Support\DeleteRestrictionException;
use Psy\Util\Json;
use Symfony\Component\Mime\Part\Multipart\FormDataPart;
use App\Message;
use App\Events\MessageCreated;
use App\Models\VersionValidation;

class ConsultationMedecineGeneraleController extends Controller
{
    use PersonnalErrors;
    use SmsTrait;
    use DossierTrait;

    protected $table = 'consultation_medecine_generales';

    /**
     * Display a listing of the resource.
     * @OA\GET(
     *      path="/consultation-medecine",
     *      operationId="GetConsultationMedecineGeneraleList",
     *      tags={"ConsultationMedecineGenerale"},
     * security={
     *  {"passport": {}},
     *   },
     *      summary="Get list of consultation medecine generale",
     *      description="Returns list of consultation medecine generale",
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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $consultations = ConsultationMedecineGenerale::with(['operationables.contributable', 'dossier', 'etablissement', 'motifs', 'traitements', 'conclusions', 'parametresCommun'])->orderByDateConsultation()->get();

        foreach ($consultations as $consultation) {
            $consultation->updateConsultationMedecine();
        }

        return response()->json(["consultations" => $consultations]);
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
      * Display a listing of the resource.
     * @OA\POST(
     *      path="/consultation-medecine",
     *      operationId="StoreConsultationMedecineGeneraleList",
     *      tags={"ConsultationMedecineGenerale"},
     * security={
     *  {"passport": {}},
     *   },
     *      summary="Store consultation medecine generale",
     *      description="Returns consultation medecine generale",
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(ConsutationMedecineRequest $request)
    {
        //dd($request->except('documents','dateRdv','motifRdv'));
        $consultation = ConsultationMedecineGenerale::create($request->except('documents','dateRdv','motifRdv'));
        $consultation->creator = Auth::id();
        $consultation->save();
        //dd($request->except('documents','dateRdv','motifRdv'));
        defineAsAuthor("ConsultationMedecineGenerale", $consultation->id, 'create', $consultation->dossier->patient->user_id);

        $consultation = ConsultationMedecineGenerale::with([
            'files',
            'motifs',
            'dossier',
            'dossier.resultatsLabo',
            'dossier.hospitalisations',
            'dossier.consultationsObstetrique',
            'dossier.consultationsMedecine',
            'dossier.resultatsImagerie',
            'dossier.allergies',
            'dossier.antecedents',
            'traitements',
            'conclusions',
            'parametresCommun',
            'etablissement'
        ])->find($consultation->id);


        //Creation du rendez vous si les information sont renseignées
        $motifRdv = $request->get('motifRdv');
        $dateRdv = $request->get('dateRdv');
        if (!is_null($dateRdv) ){
            if (strlen($dateRdv) >0 && $dateRdv != 'null' &&  $dateRdv != 'Invalid date' ){
                if ($motifRdv == 'null'){
                    $motifRdv = 'Rendez vous de la consultation medecine génerale du '.$request->get('date_consultation');
                }
                $praticien_id = $this->validationPraticien($request->get('praticien_id'));
                RendezVous::create([
                    "sourceable_id"=>$consultation->id,
                    "sourceable_type"=>'Consultation',
                    "patient_id"=>$consultation->dossier->patient->user_id,
                    "praticien_id"=>((integer) $praticien_id) !==0 ? $praticien_id :null,
                    "initiateur"=>Auth::id(),
                    "nom_medecin"=>((integer) $praticien_id) !==0 ? null :$praticien_id,
                    "motifs"=>$motifRdv,
                    "date"=>$dateRdv,
                    "statut"=>'Programmé',
                ]);
            }
        }
        $examens = $request->get('examen_complementaire');
        //$examens_validation = array();
        foreach (json_decode($examens) as $examen) {
            //dd($consultation->dossier->patient->souscripteur_id);
            $validation =  ConsultationExamenValidation::create([
                'examen_complementaire_id'=>$examen->id,
                'medecin_id'=>Auth::id(),
                'version'=>0,
                //'souscripteur_id'=>$consultation->dossier->patient->souscripteur_id,
                'souscripteur_id'=>Auth::id(),
                'consultation_general_id' => $consultation->id,
                'etablissement_id'=>$request->get('etablissement_id'),
                'ligne_de_temps_id'=>$request->get('ligne_de_temps_id'),
            ]);
            //array_push($examens_validation,$validation);
        }
        //dd($consultation->dossier->patient->medecinReferent);
        VersionValidation::create([
            'montant_prestation' => 0,
            'montant_medecin' => 0,
            'montant_souscripteur' => 0,
            'montant_total' => 0,
            'plus_value' => 0,
            'consultation_general_id' => $consultation->id,
            'version' => 0
        ]);

        /*broadcast(new MessageCreated($message))
                ->toOthers();*/

        $motifs = $request->get('motifs');
        $motifs = explode(",", $motifs);
        $conclusions = $request->get('conclusions');
        //Insertion des motifs

        foreach ($motifs as $motif) {

            $converti = (integer)$motif;
            if ($converti !== 0) {
                $consultation->motifs()->attach($motif);
                defineAsAuthor("ConsultationMotif", $motif, 'attach', $consultation->dossier->patient->user_id);

            } else {
                $item = Motif::create([
                    "reference" => $consultation->date_consultation,
                    "description" => $motif
                ]);

                defineAsAuthor("Motif", $item->id, 'create');
                $consultation->motifs()->attach($item->id);
                defineAsAuthor("ConsultationMotif", $item->id, 'attach', $consultation->dossier->patient->user_id);
            }
        }
        //Insertion de consultation
        if (!is_null($conclusions)) {
            $conclusion = Conclusion::create([
                'consultation_medecine_generale_id' => $consultation->id,
                'reference' => $consultation->date_consultation,
                "description" => $conclusions
            ]);

            defineAsAuthor("Conclusion", $conclusion->id, 'create', $conclusion->consultationMedecine->dossier->patient->user_id);

        }

        //Insertion des parametre
        $parametreCommun = ParametreCommun::create($request->only(
                "poids",
                "taille",
                "bmi",
                "ta_systolique",
                "ta_diastolique",
                "temperature",
                "frequence_cardiaque",
                "frequence_respiratoire",
                "sato2")
            +
            ["consultation_medecine_generale_id" => $consultation->id,"communable_type"=>"Consultation","communable_id"=>$consultation->id]);

        $this->updateBmi($request, $parametreCommun);

        defineAsAuthor("ParametreCommun", $parametreCommun->id, 'create', $parametreCommun->consultation->dossier->patient->user_id);

        //Insertion de traitement actuel
        $traitementsACreer = $request->get('traitements');
        if (!is_null($traitementsACreer)) {
            $traitementCreer = TraitementActuel::create([
                'description' => $traitementsACreer,
                'dossier_medical_id' => $consultation->dossier->id
            ]);

            defineAsAuthor("TraitementActuel", $traitementCreer->id, 'create', $traitementCreer->dossier->patient->user_id);
        }

        //Association de patient à l'etablissement
        $etablissement = EtablissementExercice::find($request->get('etablissement_id'));
        $patient = $consultation->dossier->patient;

        //Enregistement des contributeurs
        $contributeurs = $request->get('contributeurs');
        $contributeurs = explode(",", $contributeurs);
        if (!is_null($contributeurs)) {
            foreach ($contributeurs as $contributeur) {
                if (strlen($contributeur >0)){
                    $nouveauContributeur = Contributeurs::create([
                        'contributable_id' => $contributeur,
                        'contributable_type' => 'App\User',
                        'operationable_id' => $consultation->id,
                        'operationable_type' => 'Consultation'

                    ]);
                    defineAsAuthor("Consultation", $nouveauContributeur->id, 'Ajout contributeur', $consultation->dossier->patient->user_id);
                }
            }
        }

        //Je verifie si ce patient n'est pas encore dans cette etablissement
        $nbre = EtablissementExercicePatient::where('etablissement_id', '=', $etablissement)->where('patient_id', '=', $patient->user_id)->count();
        if ($nbre == 0) {


            $etablissement->patients()->attach($patient->user_id);

            defineAsAuthor("Patient", $patient->user_id, 'add to etablissement', $patient->user_id);
        }

        if (!is_null($consultation))
            $consultation->updateConsultationMedecine();

        if ($request->hasFile('documents')) {
            $this->uploadFile($request, $consultation);
        }
        $this->updateDossierId($consultation->dossier->id);

        return response()->json(["consultation" => $consultation]);
    }

    /**
     * Display the specified resource.
      * Store a newly created resource in storage.
      * Display a listing of the resource.
     * @OA\GET(
     *      path="/consultation-medecine/{slug} ", 
     *      operationId="ShowConsultationMedecineGeneraleList",
     *      tags={"ConsultationMedecineGenerale"},
     * security={
     *  {"passport": {}},
     *   },
     *      summary="Show consultation medecine generale",
     *      description="Returns consultation medecine generale",
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
     * @param $slug
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function show($slug)
    {
        $this->validatedSlug($slug,$this->table);

        $consultation = ConsultationMedecineGenerale::with([
            'operationables.contributable',
            'dossier',
            'dossier.resultatsLabo',
            'dossier.hospitalisations',
            'dossier.consultationsObstetrique',
            'dossier.consultationsMedecine.conclusions',
            'dossier.resultatsImagerie',
            'dossier.allergies',
            'dossier.antecedents',
            'dossier.traitements',
            'dossier.cardiologies',
            'motifs',
            'conclusions',
            'parametresCommun',
            'etablissement',
            'files',
            'rdv.praticien'
        ])->whereSlug($slug)->first();

        if (!is_null($consultation)){
            $consultation->updateConsultationMedecine();
        }
        return response()->json(["consultation"=>$consultation]);

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
     * @OA\UPDATE(
     *      path="/consultation-medecine/{slug} ", 
     *      operationId="UpdateConsultationMedecineGeneraleList",
     *      tags={"ConsultationMedecineGenerale"},
     * security={
     *  {"passport": {}},
     *   },
     *      summary="Update consultation medecine generale",
     *      description="Returns consultation medecine generale",
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
     * @param ConsutationMedecineRequest $request
     * @param $slug
     * @return \Illuminate\Http\Response
     * @throws \App\Exceptions\PersonnnalException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(ConsutationMedecineRequest $request, $slug)
    {

        $this->validatedSlug($slug,$this->table);

        $consultation = ConsultationMedecineGenerale::findBySlug($slug);

        $this->checkIfCanUpdated("ConsultationMedecineGenerale",$consultation->id,"create");

        $motifs = $request->get('motifs');

        $rConclusions = $request->get('conclusions');
        $motifs = explode(",",$motifs);

        //Insertion des motifs
        foreach ($motifs as $motif){

            $converti = (integer) $motif;

            if ($converti !== 0){
                $consultation->motifs()->attach($motif);
                defineAsAuthor("ConsultationMotif", $consultation->id, 'attach and update',$consultation->dossier->patient->user_id);
            }else{
                if ($motif != ""){

                    $item =   Motif::create([
                        "reference"=>$consultation->date_consultation,
                        "description"=>$motif
                    ]);

                    defineAsAuthor("Motif", $item->id, 'create');
                    $consultation->motifs()->attach($item->id);
                    defineAsAuthor("ConsultationMotif", $consultation->id, 'attach and update',$consultation->dossier->patient->user_id);

                }
            }
        }

        $examens = json_decode($request->get('examen_complementaire'));
        // $last_validation = ConsultationExamenValidation::where([
        //     ["consultation_general_id", $consultation->id],
        // ])->orderBy('version','DESC')
        // ->first();
        // $version =0;
        // if($last_validation->etat_validation_medecin==null){
        //     $version = $last_validation->version;
        // }else{
        //     $version = $last_validation->version+1;
        // }
        foreach ($examens as $examen) {
           $item = ConsultationExamenValidation::where([
                ["consultation_general_id", $consultation->id],
                ["examen_complementaire_id", $examen->id]
            ])->first();

            if($item == null){
                ConsultationExamenValidation::create([
                    'examen_complementaire_id'=>$examen->id,
                    'medecin_id'=>Auth::id(),
                    'souscripteur_id'=>Auth::id(),
                    //'version' => $version,
                    'consultation_general_id' => $consultation->id,
                    'etablissement_id'=>$request->get('etablissement_id'),
                    'ligne_de_temps_id'=>$request->get('ligne_de_temps_id'),
                ]);
            }
        }

        //Insertion de la conclusion
        if ((count($consultation->conclusions) ==0) && !is_null($rConclusions) ){
            $conclusion =  Conclusion::create([
                'consultation_medecine_generale_id' =>$consultation->id,
                'reference'=>$consultation->date_consultation,
                "description"=>$rConclusions
            ]);

            defineAsAuthor("Conclusion",$conclusion->id,'create and update',$conclusion->consultationMedecine->dossier->patient->user_id);

        }else{
            if (!is_null($rConclusions)){

                foreach ($consultation->conclusions as $conclusion){
                    $conclusion->description = $rConclusions;
                    $conclusion->save();
                    defineAsAuthor("Consultation conclusion",$consultation->id,'update',$conclusion->consultationMedecine->dossier->patient->user_id);

                }
            }
        }

        ConsultationMedecineGenerale::whereSlug($slug)->update($request->except(['praticien_id','motifs','conclusions','consultation','contributeurs','documents','dateRdv','motifRdv']));
        defineAsAuthor("ConsultationMedecineGenerale",$consultation->id,'update',$consultation->dossier->patient->user_id);

        $consultation = ConsultationMedecineGenerale::with(['rdv','operationables.contributable','dossier','motifs','traitements','conclusions','parametresCommun'])->whereSlug($slug)->first();

        //Modification du rendez vous de la consultation ou créattion
        $this->updateRdv($consultation,$request);

        $precedentContributeurs = [];
        //Mises à jour des contributeurs
        $contributeurs = $request->get('contributeurs');
        $contributeurs = explode(",",$contributeurs);
        if (!is_null($contributeurs)) {
            foreach ($consultation->operationables as $operation) {
                if (!in_array($operation->contributable->id, $precedentContributeurs)) {
                    array_push($precedentContributeurs, $operation->contributable->id);
                }
            }

            $difference = array_diff($contributeurs, $precedentContributeurs);
            if (!empty($difference)) {
                foreach ($difference as $contributeur) {
                    if ($contributeur !== ""){

                        $nouveauContributeur = Contributeurs::create([
                            'contributable_id' => $contributeur,
                            'contributable_type' => 'App\User',
                            'operationable_id' => $consultation->id,
                            'operationable_type' => 'Consultation'

                        ]);

                        defineAsAuthor("Consultation", $nouveauContributeur->id, 'Ajout contributeur', $consultation->dossier->patient->user_id);
                    }
                }
            }

            $difference = array_diff($precedentContributeurs, $contributeurs);

            if (!empty($difference)) {
                foreach ($difference as $contributeur) {
                    $contributeur = Contributeurs::where('contributable_id', $contributeur)
                        ->where('contributable_type', 'App\User')
                        ->where('operationable_id', $consultation->id)
                        ->where('operationable_type', 'Consultation')
                        ->first();

                    $contributeur->delete();
                    defineAsAuthor("Consultation", $contributeur, 'Retrait du contributeur ' . $contributeur, $consultation->dossier->patient->user_id);
                }
            }
        }
        $file = $consultation->file;

        if($request->hasFile('documents')){
            $this->uploadFile($request,$consultation);
        }

        if (!is_null($file))
            File::delete(public_path().'/storage/'.$file);

        $consultation->updateConsultationMedecine();
        $this->updateDossierId($consultation->dossier->id);

        return response()->json(["consultation"=>$consultation]);
    }

    /**
     * Remove the specified resource from storage.
     * @OA\DELETE(
     *      path="/consultation-medecine/{slug} ", 
     *      operationId="DeleteConsultationMedecineGeneraleList",
     *      tags={"ConsultationMedecineGenerale"},
     * security={
     *  {"passport": {}},
     *   },
     *      summary="Delete consultation medecine generale",
     *      description="Returns list of consultation medecine generale",
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
     * @param $slug
     * @return \Illuminate\Http\Response
     * @throws \App\Exceptions\PersonnnalException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function destroy($slug)
    {
        $this->validatedSlug($slug,$this->table);

        $consultation = ConsultationMedecineGenerale::with(['dossier','motifs','traitements','conclusions','parametresCommun'])->whereSlug($slug)->first();

        $this->checkIfAuthorized("ConsultationMedecineGenerale",$consultation->id,"create");

        try{
            $consultation = ConsultationMedecineGenerale::with(['dossier','motifs','traitements','conclusions','parametresCommun'])->whereSlug($slug)->first();
            $consultation->delete();
            $this->updateDossierId($consultation->dossier->id);

            return response()->json(["consultation"=>$consultation]);
        }catch (DeleteRestrictionException $deleteRestrictionException){
            $this->revealError('deletingError',$deleteRestrictionException->getMessage());
        }
    }

    /**
     * Archieved the specified resource in storage.
     *
     * @param $slug
     * @return \Illuminate\Http\Response
     * @throws \App\Exceptions\PersonnnalException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function archiver($slug)
    {
        $this->validatedSlug($slug,$this->table);

        $resultat = ConsultationMedecineGenerale::with(['dossier','motifs','traitements','conclusions','parametresCommun'])->whereSlug($slug)->first();

        if (is_null($resultat->passed_at)){
            $this->revealNonTransmis();

        }else{
            $resultat->archieved_at = Carbon::now();
            $resultat->save();

            defineAsAuthor("ConsultationMedecineGenerale",$resultat->id,'archive');
            $resultat->updateConsultationMedecine();

            $user = $resultat->dossier->patient->user;
            if ($user->decede == 'non') {
                informedPatientAndSouscripteurs($resultat->dossier->patient, 1);
                $this->updateDossierId($resultat->dossier->id);

                if ($user->isMedicasure == '1' || $user->isMedicasure == 1) {
                    $this->sendSmsToUser($user);
                }
            }
            return response()->json(['resultat'=>$resultat]);
        }
    }

    /**
     * Passed the specified resource in storage.
     *
     * @param $slug
     * @return \Illuminate\Http\Response
     * @throws \App\Exceptions\PersonnnalException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function transmettre($slug)
    {
        $this->validatedSlug($slug,$this->table);

        $resultat = ConsultationMedecineGenerale::with(['dossier','motifs','traitements','conclusions','parametresCommun'])->whereSlug($slug)->first();
        $resultat->passed_at = Carbon::now();
        $resultat->save();

        defineAsAuthor("ConsultationMedecineGenerale",$resultat->id,'transmettre');
        $resultat->updateConsultationMedecine();

        $user = $resultat->dossier->patient->user;
        if ($user->decede == 'non') {
            if ($user->isMedicasure == '0' || $user->isMedicasure == 0) {
                $this->sendSmsToUser($user);
            }
            informedPatientAndSouscripteurs($resultat->dossier->patient, 0);
            $this->updateDossierId($resultat->dossier->id);
        }
        return response()->json(['resultat'=>$resultat]);

    }

    public function reactiver($slug)
    {
        $this->validatedSlug($slug,$this->table);

        $resultat = ConsultationMedecineGenerale::with(['dossier','motifs','traitements','conclusions','parametresCommun'])->whereSlug($slug)->first();
        $resultat->passed_at = null;
        $resultat->archieved_at = null;
        $resultat->save();

        defineAsAuthor("ConsultationMedecineGenerale",$resultat->id,'reactiver');
        $resultat->updateConsultationMedecine();
        $this->updateDossierId($resultat->dossier->id);

        return response()->json(['resultat'=>$resultat]);

    }

    public function  updateBmi($request,ParametreCommun $parametreCommun){
        if (!is_null($request->get('taille') && !is_null($request->get('poids')))){
            $tailleEnMetre = $request->get('taille') * 0.01;
            $bmi=0;
            if($tailleEnMetre!=0){
                $bmi = round((($request->get('poids'))/($tailleEnMetre * $tailleEnMetre)),2);
            }
            $parametreCommun->bmi = $bmi;
            $parametreCommun->save();
        }
    }

    public function uploadFile($request, $consultation){
        foreach ($request->documents as $document){
            $path = $document->storeAs('public/DossierMedicale/' . $consultation->dossier->numero_dossier . '/ConsultationGenerale' . $request->consultation_medecine_generale_id,
                $document->getClientOriginalName());

            $file = str_replace('public/','',$path);

            $file = \App\Models\File::create([
                'fileable_type'=>'Consultation',
                'fileable_id'=>$consultation->id,
                'nom'=>$document->getClientOriginalName(),
                'extension'=>$document->getClientOriginalExtension(),
                'chemin'=>$file,
            ]);
            $this->updateDossierId($consultation->dossier->id);

            defineAsAuthor("File",$file->id,'create');

        }
    }

    public function updateRdv($consultation,$request){
        $motifRdv = $request->get('motifRdv');
        $dateRdv = $request->get('dateRdv');
        $praticien_id = $this->validationPraticien($request->get('praticien_id'));
        //je récupère le rendez vous de la consultation si cela existe
        $rdv = RendezVous::where('sourceable_id',$consultation->id)
            ->where('sourceable_type','Consultation')
            ->first();

        if ($motifRdv == 'null'){
            $motifRdv = 'Rendez vous de la consultation medecine génerale du '.$request->get('date_consultation');
        }

        if (is_null($rdv)){
//            si cela n'existe pas et que on a spécifié la date de rendez vous on crée
            if (!is_null($dateRdv) ){
                if (strlen($dateRdv) >0 && $dateRdv != 'null' &&  $dateRdv != 'Invalid date'){

                    RendezVous::create([
                        "sourceable_id"=>$consultation->id,
                        "sourceable_type"=>'Consultation',
                        "patient_id"=>$consultation->dossier->patient->user_id,
                        "praticien_id"=>((integer) $praticien_id) !==0 ? $praticien_id :null,
                        "initiateur"=>Auth::id(),
                        "nom_medecin"=>((integer) $praticien_id) !==0 ? null :$praticien_id,
                        "motifs"=>$motifRdv,
                        "date"=>$dateRdv,
                        "statut"=>'Programmé',
                    ]);
                }
            }
        }
        else{
            $rdv->date = $dateRdv;
            $rdv->motifs = $motifRdv;
            $rdv->praticien_id=((integer) $praticien_id) !==0 ? $praticien_id :null;
            $rdv->nom_medecin=((integer) $praticien_id) !==0 ? null :$praticien_id;
            $rdv->statut = 'Reprogrammé';

            $rdv->save();
        }
    }

    public function validationPraticien($praticien){

        $praticienId = (integer) $praticien;

        if ($praticienId !== 0){
            $validator = Validator::make(['praticien_id'=>$praticienId],['praticien_id'=>'required|integer|exists:users,id']);

            if($validator->fails()){
                return $this->revealError('praticien_id','le praticien spécifié n\'exite pas dans la bd');
            }else{
                return $praticienId;
            }
        }else{

            if ($praticien != ""){
                return $praticien;
            }
        }
    }
}
