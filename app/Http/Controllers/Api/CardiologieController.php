<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Traits\PersonnalErrors;
use App\Http\Requests\CardiologieRequest;
use App\Models\ActionMotif;
use App\Models\Cardiologie;
use App\Models\ConsultationMedecineGenerale;
use App\Models\Contributeurs;
use App\Models\ExamenCardio;
use App\Models\Motif;
use App\Models\ParametreCommun;
use App\Models\TraitementActuel;
use App\Traits\SmsTrait;
use App\Traits\UserTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CardiologieController extends Controller
{
    use PersonnalErrors;
    use UserTrait;
    use SmsTrait;

    protected $table = 'cardiologies';

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
     * @param CardiologieRequest $request
     * @return \Illuminate\Http\Response
     * @throws \App\Exceptions\PersonnnalException
     */
    public function store(CardiologieRequest $request)
    {
//        $this->verificationDeSpecialite();

        $cardiologie = Cardiologie::create($request->except('contributeurs', 'examen_cardio'));
        $cardiologie->creator = Auth::id();
        $cardiologie->save();

        defineAsAuthor("Cardiologie", $cardiologie->id, 'create', $cardiologie->dossier->patient->user_id);

        //Enregistrement de motif
        $this->enregistrerMotifs($request, $cardiologie);

        // Enregistrement de parametre
        $this->enregistrerParametre($request,$cardiologie);

        //Enregistrement d'examen cardio
        $this->enregistrerExamenCardio($request,$cardiologie);

        //Enregistrement de traitement actuel
        $this->enregistrerTraitementActuel($request,$cardiologie);

        //enregistrement de contributeurs
        $this->enregistrementContributeurs($request,$cardiologie);

        //enregistrement de documents
        if ($request->hasFile('documents')) {
            $this->uploadFile($request, $cardiologie);
        }

        $cardiologie = Cardiologie::with(
            'actions.motifs',
            'parametresCommun',
            'examenCardios',
            'dossier.resultatsLabo',
            'dossier.hospitalisations',
            'dossier.consultationsObstetrique',
            'dossier.consultationsMedecine',
            'dossier.resultatsImagerie',
            'dossier.allergies',
            'dossier.antecedents',
            'dossier.traitements',
            "files",
            "operationables.contributable"
        )->find($cardiologie->id);

        return response()->json(['consultation' => $cardiologie]);

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $consultation = Cardiologie::with([
            'operationables.contributable',
            'dossier.resultatsLabo',
            'dossier.hospitalisations',
            'dossier.consultationsObstetrique',
            'dossier.consultationsMedecine',
            'dossier.resultatsImagerie',
            'dossier.allergies',
            'dossier.antecedents',
            'dossier.traitements',
            'dossier.cardiologies',
            'actions.motifs',
            'parametresCommun',
            'etablissement',
            'files',
            'examenCardios'
        ])->whereSlug($slug)->first();

        $consultation->updateConsultationCardiologique();

        return response()->json(["consultation"=>$consultation]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CardiologieRequest $request
     * @param string $slug
     * @return \Illuminate\Http\Response
     * @throws \App\Exceptions\PersonnnalException
     */
    public function update(CardiologieRequest $request, $slug)
    {
        //verification si user peut modifier
//        $this->verificationDeSpecialite();

        //Modification de la consultation
        $cardiologie = Cardiologie::whereSlug($slug)->update(
            $request->only(
                "etablissement_id",
                "dossier_medical_id",
                "examen_clinique",
                "date_consultation",
                "anamnese",
                "facteur_de_risque",
                "profession",
                "situation_familiale",
                "nbre_enfant",
                "tabac",
                "alcool",
                "autres",
                "conclusion",
                "conduite_a_tenir",
                "slug",
                "nbreCigarette",
                "nbreAnnee"
            )+["rendez_vous"=>$request->get('rendez_vous') == 'null' ? null :$request->get('rendez_vous')]
        );
        $cardiologie = Cardiologie::whereSlug($slug)->first();
        defineAsAuthor("Cardiologie", $cardiologie->id, 'update', $cardiologie->dossier->patient->user_id);

        //Enregistrement de motif
        $this->enregistrerMotifs($request, $cardiologie);

        // Enregistrement de parametre
        $this->enregistrerParametre($request,$cardiologie);

        //Enregistrement d'examen cardio
        $this->enregistrerExamenCardio($request,$cardiologie);

        //Enregistrement de traitement actuel
        $this->enregistrerTraitementActuel($request,$cardiologie);

        //enregistrement de contributeurs
        $this->enregistrementContributeurs($request,$cardiologie);

        //enregistrement de documents
        if ($request->hasFile('documents')) {
            $this->uploadFile($request, $cardiologie);
        }

        $cardiologie = Cardiologie::with(
            'actions.motifs',
            'parametresCommun',
            'examenCardios',
            'dossier.resultatsLabo',
            'dossier.hospitalisations',
            'dossier.consultationsObstetrique',
            'dossier.consultationsMedecine',
            'dossier.resultatsImagerie',
            'dossier.allergies',
            'dossier.antecedents',
            'dossier.traitements',
            "files",
            "operationables.contributable"
        )->find($cardiologie->id);

        $cardiologie->updateConsultationCardiologique();
        return response()->json(['consultation' => $cardiologie]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param string $slug
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        $this->verificationDeSpecialite();

        $cardiologie = Cardiologie::with('dossier')->whereSlug($slug)->first();
        $cardiologie->delete();
        defineAsAuthor("Cardiologie", $cardiologie->id, 'delete', $cardiologie->dossier->patient->user_id);
        return response()->json(['consultation' => $cardiologie]);
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
//        $this->verificationDeSpecialite();

        $this->validatedSlug($slug,$this->table);

        $resultat = Cardiologie::with([
            'operationables.contributable',
            'dossier.resultatsLabo',
            'dossier.hospitalisations',
            'dossier.consultationsObstetrique',
            'dossier.consultationsMedecine',
            'dossier.resultatsImagerie',
            'dossier.allergies',
            'dossier.antecedents',
            'dossier.traitements',
            'dossier.cardiologies',
            'actions.motifs',
            'parametresCommun',
            'etablissement',
            'files',
            'examenCardios'])->whereSlug($slug)->first();

        if (is_null($resultat->passed_at)){
            $this->revealNonTransmis();

        }else{
            $resultat->archieved_at = Carbon::now();
            $resultat->save();

            defineAsAuthor("Cardiologie",$resultat->id,'archive');
            $resultat->updateConsultationCardiologique();;

            $user = $resultat->dossier->patient->user;
            informedPatientAndSouscripteurs($resultat->dossier->patient,1);

//            $this->sendSmsToUser($user);

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
//        $this->verificationDeSpecialite();

        $this->validatedSlug($slug,$this->table);

        $resultat = Cardiologie::with(['operationables.contributable',
            'dossier.resultatsLabo',
            'dossier.hospitalisations',
            'dossier.consultationsObstetrique',
            'dossier.consultationsMedecine',
            'dossier.resultatsImagerie',
            'dossier.allergies',
            'dossier.antecedents',
            'dossier.traitements',
            'dossier.cardiologies',
            'actions.motifs',
            'parametresCommun',
            'etablissement',
            'files',
            'examenCardios'])->whereSlug($slug)->first();
        $resultat->passed_at = Carbon::now();
        $resultat->save();

        defineAsAuthor("Cardiologie",$resultat->id,'transmettre');
        $resultat->updateConsultationCardiologique();

        $user = $resultat->dossier->patient->user;
        $this->sendSmsToUser($user);
        informedPatientAndSouscripteurs($resultat->dossier->patient,0);

        return response()->json(['resultat'=>$resultat]);

    }

    public function reactiver($slug)
    {
//        $this->verificationDeSpecialite();

        $this->validatedSlug($slug,$this->table);

        $resultat = Cardiologie::with([
            'operationables.contributable',
            'dossier.resultatsLabo',
            'dossier.hospitalisations',
            'dossier.consultationsObstetrique',
            'dossier.consultationsMedecine',
            'dossier.resultatsImagerie',
            'dossier.allergies',
            'dossier.antecedents',
            'dossier.traitements',
            'dossier.cardiologies',
            'actions.motifs',
            'parametresCommun',
            'etablissement',
            'files',
            'examenCardios'])->whereSlug($slug)->first();

        $resultat->passed_at = null;
        $resultat->archieved_at = null;
        $resultat->save();

        defineAsAuthor("Cardiologie",$resultat->id,'reactiver');
        $resultat->updateConsultationCardiologique();
        return response()->json(['resultat'=>$resultat]);

    }


    public function enregistrerMotifs($request, $cardiologie)
    {
        $ancienMotifs = [];
        $nouveauMotifs = [];

        if (!$cardiologie->actions->isEmpty()) {
            foreach ($cardiologie->actions as $action){
                array_push($ancienMotifs,$cardiologie->actions[0]->motifs->id);
            }
        }
        $nouveauMotifs = $request->get('motifs');
        $nouveauMotifs = explode(",", $nouveauMotifs);
        foreach (array_diff($nouveauMotifs, $ancienMotifs) as $item) {
            $converti = (integer)$item;
            $motif = $item;

            if ($converti == 0) {
                $motif = Motif::create([
                    "reference" => 'C' . str_random(5),
                    "description" => $item
                ]);
                defineAsAuthor("Motif", $motif->id, 'create');

                ActionMotif::create([
                    "actionable_type" => "Cardiologie",
                    "actionable_id" => $cardiologie->id,
                    "motif_id" => $motif
                ]);

                defineAsAuthor("CardiologieMotif", $cardiologie->id, 'attach and update', $cardiologie->dossier->patient->user_id);

            }else{
                ActionMotif::create([
                    "actionable_type" => "Cardiologie",
                    "actionable_id" => $cardiologie->id,
                    "motif_id" => $motif
                ]);

                defineAsAuthor("CardiologieMotif", $cardiologie->id, 'attach and update', $cardiologie->dossier->patient->user_id);

            }

        }

        //Ici je retire tous les anciens qui ne font pas partir des nouveaux

        $filtered = $cardiologie->actions->whereIn('motif_id', array_diff($ancienMotifs, $nouveauMotifs))->all();

        foreach ($filtered as $filter) {
            $action = ActionMotif::find($filter->id);
            $action->delete();
            defineAsAuthor("CardiologieMotif", $cardiologie->id, 'detach and update', $cardiologie->dossier->patient->user_id);
        }

    }

    public function enregistrerParametre($request, $cardiologie)
    {
        if (!is_null($cardiologie->parametresCommun)){
            $parametreCommun = $cardiologie->parametresCommun->first();
            //Mise a jour du parametre si le parametre existe
            if (!is_null($parametreCommun)){
                $parametreCommun->update([
                        "poids"=>$request->get('poids') == 'null' ? 0 :$request->get('poids'),
                        "taille"=>$request->get('taille') == 'null' ? 0 :$request->get('taille'),
                        "ta_systolique"=>$request->get('ta_systolique') == 'null' ? 0 :$request->get('ta_systolique'),
                        "ta_diastolique"=>$request->get('ta_diastolique') == 'null' ? 0 :$request->get('ta_diastolique'),
                        "temperature"=>$request->get('temperature') == 'null' ? 0 :$request->get('temperature'),
                        "frequence_cardiaque"=>$request->get('frequence_cardiaque') == 'null' ? 0 :$request->get('frequence_cardiaque'),
                        "frequence_respiratoire"=>$request->get('frequence_respiratoire') == 'null' ? 0 :$request->get('frequence_respiratoire'),
                        "sato2"=>$request->get('sato2') == 'null' ? 0 :$request->get('sato2'),
                        "perimetre_abdominal"=>$request->get('perimetre_abdominal') == 'null' ? 0 :$request->get('perimetre_abdominal')
                    ]
                    +
                    ["communable_id" => $cardiologie->id, "communable_type" => 'Cardiologie']);
            }else{
                //Creation du parametre sinon
                $parametreCommun = ParametreCommun::create($request->only(
                        "poids",
                        "taille",
                        "bmi",
                        "ta_systolique",
                        "ta_diastolique",
                        "temperature",
                        "frequence_cardiaque",
                        "frequence_respiratoire",
                        "sato2",
                        "perimetre_abdominal"
                    )
                    +
                    ["communable_id" => $cardiologie->id, "communable_type" => 'Cardiologie']);
            }
        }

        $this->updateBmi($request, $parametreCommun);

        defineAsAuthor("ParametreCommun", $parametreCommun->id, 'create', $cardiologie->dossier->patient->user_id);

    }

    public function updateBmi($request, ParametreCommun $parametreCommun)
    {
        if (!is_null($request->get('taille') && !is_null($request->get('poids'))) && $request->get('poids') != 'null' && $request->get('taille') != 'null') {
            $tailleEnMetre = $request->get('taille') * 0.01;
            $bmi = 0;
            if ($tailleEnMetre != 0) {
                $bmi = round((($request->get('poids')) / ($tailleEnMetre * $tailleEnMetre)), 2);
            }
            $parametreCommun->bmi = $bmi;
            $parametreCommun->save();
        }
    }

    public function enregistrerExamenCardio($request,$cardiologie)
    {
        $examens = $request->get('examen_cardio');
        if (!is_null($examens)){
            foreach ($examens as $examen){
                $examenCardio = ExamenCardio::create($examen + ['cardiologie_id'=>$cardiologie->id]);
                defineAsAuthor("ExamenCardio", $examenCardio->id, 'create', $cardiologie->dossier->patient->user_id);
            }
        }
    }

    public function enregistrerTraitementActuel($request,$cardiologie){
        //Insertion de traitement actuel
        $traitementsACreer = $request->get('traitements');
        if (!is_null($traitementsACreer)) {
            $traitementCreer = TraitementActuel::create([
                'description' => $traitementsACreer,
                'dossier_medical_id' => $cardiologie->dossier->id
            ]);

            defineAsAuthor("TraitementActuel", $traitementCreer->id, 'create', $traitementCreer->dossier->patient->user_id);
        }
    }

    public function uploadFile($request, $cardiologie){
        foreach ($request->documents as $document){
            $path = $document->storeAs('public/DossierMedicale/' . $cardiologie->dossier->numero_dossier . '/Cardiologie/' . $cardiologie->id,
                $document->getClientOriginalName());

            $file = str_replace('public/','',$path);

            $file = \App\Models\File::create([
                'fileable_type'=>'Cardiologie',
                'fileable_id'=>$cardiologie->id,
                'nom'=>$document->getClientOriginalName(),
                'extension'=>$document->getClientOriginalExtension(),
                'chemin'=>$file,
            ]);

            defineAsAuthor("File",$file->id,'create');

        }
    }

    public function enregistrementContributeurs($request,$cardiologie){
        //Enregistement des contributeurs
        $contributeurs = $request->get('contributeurs');
        $contributeurs = explode(",", $contributeurs);

        //On recupère les anciens contributeurs
        $ancienContributeurs = [];
        if (!$cardiologie->operationables->isEmpty()){
            foreach ($cardiologie->operationables as $operationable){
                if (!is_null($operationable->contributable)){
                    if (!in_array($operationable->contributable->id,$ancienContributeurs)){
                     array_push($ancienContributeurs,$operationable->contributable->id);
                    }
                }
            }
        }
        //on va créer les nouveaux qui ne font pas partis des anciens
        if (!is_null($contributeurs)) {
            foreach (array_diff($contributeurs,$ancienContributeurs) as $contributeur) {
                if (strlen($contributeur >0)){
                    $nouveauContributeur = Contributeurs::create([
                        'contributable_id' => $contributeur,
                        'contributable_type' => 'App\User',
                        'operationable_id' => $cardiologie->id,
                        'operationable_type' => 'Cardiologie'

                    ]);

                    defineAsAuthor("Cardiologie", $nouveauContributeur->id, 'Ajout contributeur', $cardiologie->dossier->patient->user_id);
                }
            }
        }
        //Supprimer les anciens qui ne font pas partis des nouveaux
        $filtered = array_diff($ancienContributeurs,$contributeurs);
        foreach ($filtered as $filter){
            $contributeurList = Contributeurs::where('operationable_type','Cardiologie')
            ->where('operationable_id',$cardiologie->id)->where('contributable_id',$filter)->get();
          foreach ($contributeurList as $item){
              $item->delete();
          }
        }

    }

    public function verificationDeSpecialite(){
        $reponse = $this->estIlSpecialisteDe('Cardiologie');

        if ($reponse == false){
            $this->revealAccesRefuse();
        }
    }
}
