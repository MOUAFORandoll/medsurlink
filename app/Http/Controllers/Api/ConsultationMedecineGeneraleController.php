<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\PersonnalErrors;
use App\Http\Requests\ConsutationMedecineRequest;
use App\Models\Antecedent;
use App\Models\Conclusion;
use App\Models\ConsultationMedecineGenerale;
use App\Models\Contributeurs;
use App\Models\EtablissementExercice;
use App\Models\EtablissementExercicePatient;
use App\Models\Motif;
use App\Models\ParametreCommun;
use App\Models\Patient;
use App\Models\Traitement;
use App\Models\TraitementActuel;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Netpok\Database\Support\DeleteRestrictionException;

class ConsultationMedecineGeneraleController extends Controller
{
    use PersonnalErrors;
    protected $table = 'consultation_medecine_generales';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $consultations = ConsultationMedecineGenerale::with(['contributeurs','dossier','etablissement','motifs','traitements','conclusions','parametresCommun'])->orderByDateConsultation()->get();

        foreach ($consultations as $consultation){
            $consultation->updateConsultationMedecine();
        }

        return response()->json(["consultations"=>$consultations]);
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
    public function store(ConsutationMedecineRequest $request)
    {

        if($request->hasFile('file')) {

            if ($request->file('file')->isValid()) {
                $consultation = ConsultationMedecineGenerale::create($request->validated());
                $this->uploadFile($request,$consultation);
                defineAsAuthor("ConsultationMedecineGenerale",$consultation->id,'create',$consultation->dossier->patient->user_id);

                $consultation = ConsultationMedecineGenerale::with([
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
                //Insertion de l'image

                $motifs = $request->get('motifs');
                $motifs = explode(",",$motifs);

                $conclusions = $request->get('conclusions');

                //Insertion des motifs
                foreach ($motifs as $motif){

                    $converti = (integer) $motif;

                    if ($converti !== 0){
                        $consultation->motifs()->attach($motif);
                        defineAsAuthor("ConsultationMotif", $motif, 'attach',$consultation->dossier->patient->user_id);
                    }else{
                        $item =   Motif::create([
                            "reference"=>$consultation->date_consultation,
                            "description"=>$motif
                        ]);

                        defineAsAuthor("Motif", $item->id, 'create');
                        $consultation->motifs()->attach($item->id);
                        defineAsAuthor("ConsultationMotif", $item->id, 'attach',$consultation->dossier->patient->user_id);

                    }
                }
                //Insertion de consultation
                if (!is_null($conclusions)){
                    $conclusion =  Conclusion::create([
                        'consultation_medecine_generale_id' =>$consultation->id,
                        'reference'=>$consultation->date_consultation,
                        "description"=>$conclusions
                    ]);

                    defineAsAuthor("Conclusion",$conclusion->id,'create',$conclusion->consultationMedecine->dossier->patient->user_id);

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
                        "sato2")
                    +
                    [ "consultation_medecine_generale_id"=>$consultation->id]);

                $this->updateBmi($request,$parametreCommun);

                defineAsAuthor("ParametreCommun",$parametreCommun->id,'create',$parametreCommun->consultation->dossier->patient->user_id);

                //Insertion de traitement actuel
                $traitementsACreer = $request->get('traitements');
                if (!is_null($traitementsACreer))
                {
                    $traitementCreer = TraitementActuel::create([
                        'description'=>$traitementsACreer,
                        'dossier_medical_id'=>$consultation->dossier->id
                    ]);

                    defineAsAuthor("TraitementActuel", $traitementCreer->id,'create',$traitementCreer->dossier->patient->user_id);
                }

                //Association de patient à l'etablissement
                $etablissement = EtablissementExercice::find($request->get('etablissement_id'));
                $patient = $consultation->dossier->patient;

                //Enregistement des contributeurs
                $contributeurs = $request->get('contributeurs');
                $contributeurs = explode(",",$contributeurs);
                if (!is_null($contributeurs)){
                    foreach ($contributeurs as $contributeur){
                        $nouveauContributeur = Contributeurs::create([
                            'contributable_id'=>$contributeur,
                            'contributable_type'=>'App\User'
                        ]);
                        defineAsAuthor("Consultation",$nouveauContributeur->id,'Ajout contributeur',$consultation->dossier->patient->user_id);
                    }
                }

                //Je verifie si ce patient n'est pas encore dans cette etablissement
                $nbre = EtablissementExercicePatient::where('etablissement_id','=',$etablissement)->where('patient_id','=',$patient->user_id)->count();
                if ($nbre ==0){


                    $etablissement->patients()->attach($patient->user_id);

                    defineAsAuthor("Patient",$patient->user_id,'add to etablissement',$patient->user_id);
                }

                if(!is_null($consultation))
                    $consultation->updateConsultationMedecine();

                return response()->json(["consultation"=>$consultation]);
            }

            return response()->json(
                [
                    'file' => 'File is not valid'
                ],
                422
            );
        }else{
            $consultation = ConsultationMedecineGenerale::create($request->validated());
            defineAsAuthor("ConsultationMedecineGenerale",$consultation->id,'create',$consultation->dossier->patient->user_id);

            $consultation = ConsultationMedecineGenerale::with([
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
            ])->whereId($consultation->id)->first();

            //Insertion de l'image

            $motifs = $request->get('motifs');

            $conclusions = $request->get('conclusions');
            $motifs = explode(",",$motifs);
            //Insertion des motifs
            foreach ($motifs as $motif){

                $converti = (integer) $motif;

                if ($converti !== 0){
                    $consultation->motifs()->attach($motif);
                    defineAsAuthor("ConsultationMotif", $motif, 'attach',$consultation->dossier->patient->user_id);
                }else{
                    $item =   Motif::create([
                        "reference"=>$consultation->date_consultation,
                        "description"=>$motif
                    ]);

                    defineAsAuthor("Motif", $item->id, 'create');
                    $consultation->motifs()->attach($item->id);
                    defineAsAuthor("ConsultationMotif", $item->id, 'attach',$consultation->dossier->patient->user_id);

                }
            }
            //Insertion de consultation
            if (!is_null($conclusions)){
                $conclusion =  Conclusion::create([
                    'consultation_medecine_generale_id' =>$consultation->id,
                    'reference'=>$consultation->date_consultation,
                    "description"=>$conclusions
                ]);

                defineAsAuthor("Conclusion",$conclusion->id,'create',$conclusion->consultationMedecine->dossier->patient->user_id);
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
                    "sato2")
                +
                [ "consultation_medecine_generale_id"=>$consultation->id]);

            $this->updateBmi($request,$parametreCommun);

            defineAsAuthor("ParametreCommun",$parametreCommun->id,'create',$parametreCommun->consultation->dossier->patient->user_id);

//        Insertion de traitement actuel
            $traitementsACreer = $request->get('traitements');
            if (!is_null($traitementsACreer))
            {
                $traitementCreer = TraitementActuel::create([
                    'description'=>$traitementsACreer,
                    'dossier_medical_id'=>$consultation->dossier->id
                ]);

                defineAsAuthor("TraitementActuel", $traitementCreer->id,'create',$traitementCreer->dossier->patient->user_id);
            }

            //Association de patient à l'etablissement
            $etablissement = EtablissementExercice::find($request->get('etablissement_id'));
            $patient = $consultation->dossier->patient;

            //Enregistement des contributeurs

            $contributeurs = $request->get('contributeurs');
            $contributeurs = explode(",",$contributeurs);
            if (!is_null($contributeurs)){
                foreach ($contributeurs as $contributeur){
                    $nouveauContributeur = Contributeurs::create([
                        'contributable_id'=>$contributeur,
                        'contributable_type'=>'App\User'
                    ]);
                    defineAsAuthor("Consultation",$nouveauContributeur->id,'Ajout contributeur',$consultation->dossier->patient->user_id);
                }
            }

            //Je verifie si ce patient n'est pas encore dans cette etablissement
            $nbre = EtablissementExercicePatient::where('etablissement_id','=',$etablissement)->where('patient_id','=',$patient->user_id)->count();
            if ($nbre ==0){


                $etablissement->patients()->attach($patient->user_id);

                defineAsAuthor("Patient",$patient->user_id,'add to etablissement',$patient->user_id);
            }

            if(!is_null($consultation))
                $consultation->updateConsultationMedecine();

            return response()->json(["consultation"=>$consultation]);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param $slug
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function show($slug)
    {
        $this->validatedSlug($slug,$this->table);

        $consultation = ConsultationMedecineGenerale::with([
            'contributeurs',
            'dossier',
            'dossier.allergies',
            'dossier.antecedents',
            'dossier.resultatsLabo',
            'dossier.hospitalisations',
            'dossier.consultationsObstetrique',
            'dossier.consultationsMedecine',
            'dossier.resultatsImagerie',
            'dossier.allergies',
            'dossier.antecedents',
            'dossier.traitements',
            'motifs',
            'conclusions',
            'parametresCommun',
            'etablissement'
        ])->whereSlug($slug)->first();

        $consultation->updateConsultationMedecine();

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
     *
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
                $item =   Motif::create([
                    "reference"=>$consultation->date_consultation,
                    "description"=>$motif
                ]);

                defineAsAuthor("Motif", $item->id, 'create');
                $consultation->motifs()->attach($item->id);
                defineAsAuthor("ConsultationMotif", $consultation->id, 'attach and update',$consultation->dossier->patient->user_id);

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

        ConsultationMedecineGenerale::whereSlug($slug)->update($request->except(['motifs','conclusions','consultation']));
        defineAsAuthor("ConsultationMedecineGenerale",$consultation->id,'update',$consultation->dossier->patient->user_id);

        $consultation = ConsultationMedecineGenerale::with(['dossier','motifs','traitements','conclusions','parametresCommun'])->whereSlug($slug)->first();

        $file = $consultation->file;

        if($request->hasFile('file')){
            $this->uploadFile($request,$consultation);
        }

        if (!is_null($file))
            File::delete(public_path().'/storage/'.$file);

        $consultation->updateConsultationMedecine();

        return response()->json(["consultation"=>$consultation]);
    }

    /**
     * Remove the specified resource from storage.
     *
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
        if ($request->file('file')->isValid()) {
            $path = $request->file->storeAs('public/DossierMedicale/' . $consultation->dossier->numero_dossier . '/ConsultationGenerale' . $request->consultation_medecine_generale_id,$request->file('file')->getClientOriginalName());
            $file = str_replace('public/','',$path);

            $consultation->file = $file;

            $consultation->save();
        }
    }
}
