<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Souscripteur;
use App\Http\Controllers\Controller;
use App\Mail\ValidationFinanciere;
use App\Models\ConsultationExamenValidation;
use App\Models\ConsultationMedecineGenerale;
use App\Models\DossierMedical;
use App\Models\EtablissementPrestation;
use App\Models\ExamenEtablissementPrix;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\VersionValidation;
use App\Models\ExamenComplementaire;
use App\Models\LigneDeTemps;
use Barryvdh\DomPDF\PDF;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use stdClass;

class ConsultationExamenValidationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $examen_validation = ConsultationExamenValidation::with(['consultation.ligneDeTemps.motif','consultation.dossier.patient.user','consultation.author'])
        //->whereNull('etat_validation_medecin')
        ->distinct()
        ->get(['consultation_general_id']);
        $examen_validation = $examen_validation->sortByDesc('updated_at');
        return response()->json(['examen_validation'=>$examen_validation]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getListExamenToValidate($slug)
    {
        $consultation = ConsultationMedecineGenerale::whereSlug($slug)->first();
        $etablissement = $consultation->etablissement_id;
        $examen_validation = ConsultationExamenValidation::with(['consultation.dossier.patient.user','examenComplementaire','etablissement','examenComplementaire.examenComplementairePrix' => function ($query) use ($etablissement) {
            $query->where('etablissement_exercices_id', '=', $etablissement);
        }])->where('consultation_general_id', '=', $consultation->id)->latest()->get();
        return response()->json(['examen_validation'=>$examen_validation]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getExamenValidationSouscripteur()
    {
        //$examen_validation = ConsultationExamenValidation::with(['examenComplementaire'])->where('souscripteur_id', '=',Auth::id())->latest()->get();
        //return response()->json(['examen_validation'=>$examen_validation]);
        $examen_validation = ConsultationExamenValidation::with(['consultation.ligneDeTemps.motif','consultation.dossier.patient.user','consultation.author'])
        //->whereNull('etat_validation_souscripteur')
        ->where(['souscripteur_id' => Auth::id(), 'etat_validation_medecin' => 1])
        ->latest()->get()->unique('consultation_general_id');



        $examen_validations = collect();


        foreach($examen_validation as $examen){
            // $const = ConsultationMedecineGenerale::where('id',1179)->first();
            //$const = ConsultationMedecineGenerale::where('id', 1179)->first();
            $const = ConsultationMedecineGenerale::find($examen->consultation_general_id);
            if($const != null){
                $const = $const->load('ligneDeTemps.motif','dossier.patient.user','author');
                $new_exam = new stdClass();

                $new_exam->consultation_general_id = $examen->consultation_general_id;
                $new_exam->etat_validation_souscripteur = $examen->etat_validation_souscripteur;
                $new_exam->consultation = $const;
                $examen_validations->push($new_exam);
            }
            // dd($const);
            //$examen->consultation = ConsultationMedecineGenerale::find($examen->consultation_general_id)->load('ligneDeTemps.motif','dossier.patient.user','author');

        }
        return response()->json(['examen_validation'=>$examen_validations]);
    }
    /**
     * Count nomber of validation.
     *
     * @return \Illuminate\Http\Response
     */
    public function getCountInvalidation()
    {
        $examen_validation = ConsultationExamenValidation::with(['consultation.ligneDeTemps.motif','consultation.dossier.patient.user','consultation.author'])
        //->whereNull('etat_validation_medecin')
        ->distinct()
        ->get(['consultation_general_id']);;
        return response()->json(['examen_validation'=>$examen_validation->count()]);
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
    public function store(Request $request)
    {
        $examen_validation =  ConsultationExamenValidation::create([
            'souscripteur_id'=>$request->get('souscripteur_id'),
            'examen_complementaire_id'=>$request->get('examen_complementaire_id'),
            'medecin_id'=>$request->get('medecin_id'),
            'medecin_control_id'=>$request->get('medecin_control_id'),
            'ligne_de_temps_id'=>$request->get('ligne_de_temps_id'),
            'etat_validation_medecin'=>$request->get('etat_validation_medecin'),
            'etat_validation_souscripteur'=>$request->get('etat_validation_souscripteur'),
            'date_validation_medecin'=>$request->get('date_validation_medecin'),
            'date_validation_souscripteur'=>$request->get('date_validation_souscripteur'),
            'version'=>1
        ]);

        return  response()->json(['examen_validation'=>$examen_validation]);
    }
    /**
     * Update medecin validation.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function setEtatValidationMedecin(Request $request)
    {
        /**
         *  $examens contient les examens valider par le medécin controle
         */
        $examens = collect();
        $is_update = 0;
        foreach($request->get('examens') as $examen){
            $examen_validation = ConsultationExamenValidation::where('id',$examen['id'])->first();
            $ancienne_valeur = $examen_validation->etat_validation_medecin;
            $examen_validation->etat_validation_medecin = $examen['etat'];
            $examen_validation->medecin_control_id = Auth::id();
            $examen_validation->date_validation_medecin = Carbon::now();
            /**
             * Sauvegarde de la validation si nous avons des changements au niveau de la validation d'un examen
             */
            if($ancienne_valeur != $examen['etat']){
                $examen_validation->save();
                $is_update = 1;
            }
            /**
             * Listing des prestations valider par le medécin controle pour la validation du souscripteur
             */
            if($examen['etat']){
                $exam = ExamenEtablissementPrix::where(['etablissement_exercices_id' => $examen_validation->etablissement_id, 'examen_complementaire_id' => $examen_validation->examen_complementaire_id])->first();
                $exam = $exam->makeHidden(['id', 'etablissement_exercices_id','examen_complementaire_id', 'other_complementaire_id', 'created_at', 'updated_at', 'deleted_at']);
                $exam->fr_description = $exam->examenComplementaire->fr_description;
                $examens->push($exam);
            }

        }
        /**
         * envoie du mail du souscripteur lui demandant de valider
         */
        if($is_update){
            Mail::to($examen_validation->souscripteur->user->email)->send(new ValidationFinanciere($examen_validation->souscripteur->user, $examen_validation->consultation->dossier->patient->user, $examens));
        }

        return  response()->json(['examen_validation' => $examen_validation]);
    }
    /**
     * Update medecin validation.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function setEtatValidationSouscripteur(Request $request)
    {

        $totalPrestation = 0;
        $montant_medecin = 0;
        $montant_souscripteur = 0;
        $montant_total = 0;
        $plus_value = 0;
        $examens = $request->get('examens');
        $examens_id = array_column($examens, 'id');
        if(count($examens) > 0){

            $consultation = ConsultationMedecineGenerale::whereId($examens[0]['consultation'])->first();

            $etablissement = $consultation->etablissement_id;
            $examen_validation = ConsultationExamenValidation::with(['examenComplementaire','etablissement','examenComplementaire.examenComplementairePrix' => function ($query) use ($etablissement) {
                $query->where('etablissement_exercices_id', '=', $etablissement);
            }])->where('consultation_general_id', '=', $consultation->id)->latest()->get();

            $version_validation = VersionValidation::where(["consultation_general_id" => $examens[0]['consultation'], 'ligne_de_temps_id' => $consultation->ligne_de_temps_id])->first();
            if(!is_null($version_validation)){
                $version_validation->version += 1;
                $version_validation->save();
            }else{
                $version_validation = VersionValidation::create([
                    'montant_prestation' => 0,
                    'montant_medecin' => 0,
                    'montant_souscripteur' => 0,
                    'montant_total' => 0,
                    'plus_value' => 0,
                    'consultation_general_id' => $examens[0]['consultation'],
                    'ligne_de_temps_id' => $consultation->ligne_de_temps_id,
                    'version' => 1
                ]);
            }


            foreach($examen_validation as $examen){
                if(in_array($examen->id, $examens_id)){
                    $montant_souscripteur += $examen->examenComplementaire->examenComplementairePrix[0]->prix;
                    $examen->etat_validation_souscripteur = 1;
                    $examen->version += 1;
                    $examen->date_validation_souscripteur = Carbon::now();
                    $examen->save();
                }else{
                    $examen->etat_validation_souscripteur = 0;
                    $examen->version += 1;
                    $examen->date_validation_souscripteur = Carbon::now();
                    $examen->save();
                }

                $totalPrestation += $examen->examenComplementaire->examenComplementairePrix[0]->prix;
                if($examen->etat_validation_medecin == 1){
                    $montant_medecin += $examen->examenComplementaire->examenComplementairePrix[0]->prix;
                }
                if($examen->etat_validation_medecin == 1 && $examen->etat_validation_souscripteur == 1){
                    $montant_total += $examen->examenComplementaire->examenComplementairePrix[0]->prix;
                }

            }

            $plus_value = $montant_total;

            $version_validation->plus_value = $plus_value;
            $version_validation->montant_total = $montant_total;

            $version_validation->montant_medecin = $montant_medecin;
            $version_validation->montant_souscripteur = $montant_souscripteur;

            $version_validation->save();
        }

        return  response()->json(['examen_validation'=>true]);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $examen_validation = ConsultationExamenValidation::whereId($id)->with(['examenComplementaire','otherExamenComplementaire','etablissement'])->first();
        return response()->json(['examen_validation' => $examen_validation]);
    }

    /**
    * calcul du bilan globale financier en fonction de la ligne de temps et de la version de validation
    */
    public function versionValidation($ligne_temps_id, $version, $acteur){

        $validations = [];

        $examen_validation = ConsultationExamenValidation::where('ligne_de_temps_id', $ligne_temps_id)->first();

        $validations = DB::table('model_changes_history')->where(['after_changes->version' => $version, 'after_changes->ligne_de_temps_id' => $ligne_temps_id, 'changer_id' => $examen_validation->souscripteur_id, 'model_type' => 'App\Models\ConsultationExamenValidation', 'change_type' => 'updated'])->orderBy('created_at', 'desc')->get(['after_changes'])->unique(function ($item) {
            $after_changes = json_decode($item->after_changes);
            return $after_changes->id;
        });

        $validations = $validations->transform(function ($item, $key) {
            $consultation_examenvalidation = json_decode($item->after_changes);
            $examen_prix = ExamenEtablissementPrix::where(['examen_complementaire_id' => $consultation_examenvalidation->examen_complementaire_id, 'etablissement_exercices_id' => $consultation_examenvalidation->etablissement_id])->latest()->first();
            $consultation_examenvalidation->prix = $examen_prix->prix;
            // dd($examen_prix->prix);
            $consultation_examenvalidation->examen = ExamenComplementaire::find($consultation_examenvalidation->examen_complementaire_id)->fr_description;
            return $consultation_examenvalidation;
        });

        return response()->json($validations);
    }

    /**
    * calcul du bilan globale financier en fonction de la ligne de temps
    */
    public function ligneTempsBilan($ligne_temps_id){

        $examen_validation = ConsultationExamenValidation::where('ligne_de_temps_id', $ligne_temps_id)->first();
        $bilans = collect([]);
        if($examen_validation){
            $bilans = DB::table('model_changes_history')->where(['after_changes->ligne_de_temps_id' => $ligne_temps_id, 'changer_id' => $examen_validation->souscripteur_id, 'model_type' => 'App\Models\ConsultationExamenValidation', 'change_type' => 'updated'])->orderBy('created_at', 'desc')->get(['after_changes'])->unique(function ($item) {
                $after_changes = json_decode($item->after_changes);
                return $after_changes;
            });
        }

        $bilans = $bilans->transform(function ($item, $key) {
            $consultation_examenvalidation = json_decode($item->after_changes);
            $examen_prix = ExamenEtablissementPrix::where(['examen_complementaire_id' => $consultation_examenvalidation->examen_complementaire_id, 'etablissement_exercices_id' => $consultation_examenvalidation->etablissement_id])->latest()->first();
            if(!is_null($examen_prix)){
                $consultation_examenvalidation->prix = $examen_prix->prix;
            }else{
                $examen_prix = ExamenEtablissementPrix::where(['examen_complementaire_id' => $consultation_examenvalidation->examen_complementaire_id])->latest()->first();
                $consultation_examenvalidation->prix = $examen_prix->prix;
            }
            $consultation_examenvalidation->examen = ExamenComplementaire::find($consultation_examenvalidation->examen_complementaire_id)->fr_description;
            return $consultation_examenvalidation;
        })->groupBy('version');

        return response()->json($bilans);
    }


    public function BilanFinancier($patient){

        return response()->json(['link' => route('patient.bilan', $patient)]);
    }

    /**
    * calcul du bilan globale financier de toute les lignes de temps
    */
    public function bilanGlobalFiancier($dossier){

        $dossier = DossierMedical::where('slug', $dossier)->first();
        $ligne_temp_ids = LigneDeTemps::where('dossier_medical_id', $dossier->id)->get()->pluck('id');
        $examen_validations = ConsultationExamenValidation::whereIn('ligne_de_temps_id', $ligne_temp_ids)->get();

        $examen_validations = $examen_validations->transform(function ($item, $key) {
            $examen_prix = ExamenEtablissementPrix::where(['examen_complementaire_id' => $item->examen_complementaire_id, 'etablissement_exercices_id' => $item->etablissement_id])->latest()->first();
            if(!is_null($examen_prix)){
                $item->prix = $examen_prix->prix;
            }else{
                $examen_prix = ExamenEtablissementPrix::where(['examen_complementaire_id' => $item->examen_complementaire_id])->latest()->first();
                $item->prix = $examen_prix->prix;
            }
            return $item;
        });

        $total_prescription = $examen_validations->sum('prix');
        $total_medecin_controle = $examen_validations->where('etat_validation_medecin', 1)->sum('prix');
        $total_medecin_assureur = $examen_validations->where('etat_validation_souscripteur', 1)->sum('prix');

        return response()->json(['total_prescription' => $total_prescription, 'total_medecin_controle' => $total_medecin_controle, 'total_medecin_assureur' => $total_medecin_assureur]);
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
        //
    }
}
