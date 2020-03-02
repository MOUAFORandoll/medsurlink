<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\CardiologieRequest;
use App\Models\ActionMotif;
use App\Models\Cardiologie;
use App\Models\ConsultationMedecineGenerale;
use App\Models\Contributeurs;
use App\Models\ExamenCardio;
use App\Models\Motif;
use App\Models\ParametreCommun;
use App\Models\TraitementActuel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CardiologieController extends Controller
{
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(CardiologieRequest $request)
    {

        $cardiologie = Cardiologie::create($request->except('contributeurs', 'examen_cardio'));
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
     * @param \Illuminate\Http\Request $request
     * @param string $slug
     * @return \Illuminate\Http\Response
     */
    public function update(CardiologieRequest $request, $slug)
    {
        //verification si user peut modifier

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
                "rendez_vous",
                "slug",
                "nbreCigarette",
                "nbreAnnee"
            )
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

        return response()->json(['consultation' => $cardiologie]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function enregistrerMotifs($request, $cardiologie)
    {
        $ancienMotifs = [];
        $nouveauMotifs = [];

        if (!$cardiologie->actions->isEmpty()) {
            $ancienMotifs = $cardiologie->actions->motifs->pluck('id')->all();
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
            }

            ActionMotif::create([
                "actionable_type" => "Cardiologie",
                "actionable_id" => $cardiologie->id,
                "motif_id" => $motif
            ]);

            defineAsAuthor("CardiologieMotif", $cardiologie->id, 'attach and update', $cardiologie->dossier->patient->user_id);
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

        $this->updateBmi($request, $parametreCommun);

        defineAsAuthor("ParametreCommun", $parametreCommun->id, 'create', $cardiologie->dossier->patient->user_id);

    }

    public function updateBmi($request, ParametreCommun $parametreCommun)
    {
        if (!is_null($request->get('taille') && !is_null($request->get('poids')))) {
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
        if (!is_null($contributeurs)) {
            foreach ($contributeurs as $contributeur) {
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
    }
}
