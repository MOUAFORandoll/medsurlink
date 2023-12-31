<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Traits\PersonnalErrors;
use App\Http\Requests\ConsultationFichierRequest;
use App\Models\ConsultationFichier;
use App\Models\DossierMedical;
use App\Traits\DossierTrait;
use App\Traits\SmsTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ActiviteAmaPatient;
use App\Models\Affiliation;
use App\Models\ConsultationMedecineGenerale;
use App\Models\DelaiOperation;
use App\Models\LigneDeTemps;
use App\User;
use Illuminate\Support\ConfigurationUrlParser;

class ConsultationFichierController extends Controller
{
    use PersonnalErrors;
    use DossierTrait;
    use SmsTrait;

    protected $table = 'consultation_fichiers';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $consultations = ConsultationFichier::with(['dossier','etablissement','files'])->latest()->get();

        return response()->json(['consultations'=>$consultations]);
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
    public function store(ConsultationFichierRequest $request)
    {
        $dossier = DossierMedical::whereSlug($request->dossier_medical_id)->first();

        $user_id = $request->user_id;
        $name = $request->name;

        if (is_null($name) || $name=='null'){
            $consultation_externe = $request->consultation_externe;
        }else{
            $consultation_externe = '';
        }

        if (is_null($user_id) || $user_id == 'null'){
            $praticien_externe = $request->praticien_externe;
        }else{
            $praticien_externe = '';
        }

        $consultation = ConsultationFichier::create(
            $request->except('dossier_medical_id','documents','user_id','praticien_externe','name','consultation_externe')
            + [
                'dossier_medical_id'=>$dossier->id,
                'user_id'=>$user_id,
                'praticien_externe'=>$praticien_externe,
                'name'=>$name,
                'consultation_externe'=>$consultation_externe
            ]);

        if ($request->hasFile('documents')) {
            $this->uploadFile($request, $consultation);
        }

        $affiliation = Affiliation::where("patient_id", $dossier->patient_id)->latest()->first();
        $ligne_temps = LigneDeTemps::where('dossier_medical_id', $dossier->id)->latest()->first();
        $user = User::find($dossier->patient_id);
        $activite = ActiviteAmaPatient::create([
            'activite_ama_id' => 1,
            'date_cloture' => $request->date_consultation,
            'affiliation_id' => $affiliation ? $affiliation->id : null,
            'commentaire' => "Ajout d'un fichier externe pour le patient {$user->name}",
            'ligne_temps_id' => $ligne_temps ? $ligne_temps->id : null,
            'patient_id' => $dossier->patient_id,
            'etablissement_id' => 4,
            'statut' => $request->statut,
        ]);


        $consultation = ConsultationFichier::with(['dossier','etablissement','files','praticien'])->whereSlug($consultation->slug)->first();
        $this->updateDossierId($consultation->dossier->id);

        $consultation_medecine_generale = ConsultationMedecineGenerale::latest()->where('dossier_medical_id', $consultation->dossier->id)->first();

        DelaiOperation::create(
            [
                "patient_id" => $dossier->patient_id,
                "delai_operationable_id" => $consultation->id,
                "delai_operationable_type" => ConsultationFichier::class,
                "date_heure_prevue" => $consultation_medecine_generale ? $consultation_medecine_generale->created_at : Carbon::now(),
                "date_heure_effectif" => $consultation ? $consultation->created_at : Carbon::now(),
                "observation" => "RAS"
            ]
        );

        return response()->json(["consultation" => $consultation]);

    }

    /**
     * Display the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $this->validatedSlug($slug,$this->table);

        $consultation = ConsultationFichier::with(['dossier','etablissement','files','praticien'])->whereSlug($slug)->first();
        $consultation->updateConsultation();
        return response()->json(['consultation'=>$consultation]);
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
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function update(ConsultationFichierRequest $request, $slug)
    {
        $this->validatedSlug($slug,$this->table);
        $dossier = DossierMedical::whereSlug($request->dossier_medical_id)->first();

        $user_id = $request->user_id;
        $name = $request->name;

        if (is_null($name) || $name == 'null'){
            $consultation_externe = $request->consultation_externe;
        }else{
            $consultation_externe = '';
        }

        if (is_null($user_id) || $user_id == 'null'){
            $praticien_externe = $request->praticien_externe;
        }else{
            $praticien_externe = '';
        }

        ConsultationFichier::whereSlug($slug)->update(
            $request->except('dossier_medical_id','documents','user_id','praticien_externe','name','consultation_externe')
            + [
                'dossier_medical_id'=>$dossier->id,
                'user_id'=>$user_id,
                'praticien_externe'=>$praticien_externe,
                'name'=>$name,
                'consultation_externe'=>$consultation_externe
            ]);

        $consultation = ConsultationFichier::with(['dossier','etablissement','files','praticien'])->whereSlug($slug)->first();

        if ($request->hasFile('documents')) {
            $this->uploadFile($request, $consultation);
        }

        $consultation->updateConsultation();
        $this->updateDossierId($consultation->dossier->id);

        return response()->json(['consultation'=>$consultation]);

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        $this->validatedSlug($slug,$this->table);

        $consultation = ConsultationFichier::with(['dossier'])->whereSlug($slug)->first();

        $consultation->delete();
//        $consultation->updateConsultation();
        $this->updateDossierId($consultation->dossier->id);

        return response()->json(['consultation'=>$consultation]);
    }

    public function addFile(Request $request, $slug){
        $this->validatedSlug($slug, $this->table);

        $consultation = ConsultationFichier::with(['dossier','etablissement','files','praticien'])->whereSlug($slug)->first();

        if ($request->hasFile('documents')) {
            $this->uploadFile($request, $consultation);
        }

        $consultation->updateConsultation();
        $this->updateDossierId($consultation->dossier->id);

        return response()->json(['consultation'=>$consultation]);
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

        $resultat = ConsultationFichier::with(['dossier','etablissement','files','praticien'])->whereSlug($slug)->first();

        if (is_null($resultat->passed_at)){
            $this->revealNonTransmis();

        }else{
            $resultat->archieved_at = Carbon::now();
            $resultat->save();
            $resultat->updateConsultation();
            $this->updateDossierId($resultat->dossier->id);

            $user = $resultat->dossier->patient->user;
            if ($user->decede == 'non') {
                informedPatientAndSouscripteurs($resultat->dossier->patient, 1);
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

        $resultat = ConsultationFichier::with(['dossier','etablissement','files','praticien'])->whereSlug($slug)->first();
        $resultat->passed_at = Carbon::now();
        $resultat->save();
        $resultat->updateConsultation();
        $this->updateDossierId($resultat->dossier->id);
        $user = $resultat->dossier->patient->user;
        if ($user->decede == 'non') {
            informedPatientAndSouscripteurs($resultat->dossier->patient, 0);
            if ($user->isMedicasure == '0' || $user->isMedicasure == 0) {
                $this->sendSmsToUser($user);
            }
        }
        return response()->json(['resultat'=>$resultat]);

    }

    public function reactiver($slug)
    {
        $this->validatedSlug($slug,$this->table);

        $resultat = ConsultationFichier::with(['dossier','etablissement','files','praticien'])->whereSlug($slug)->first();
        $resultat->passed_at = null;
        $resultat->archieved_at = null;
        $resultat->save();
        $resultat->updateConsultation();
        $this->updateDossierId($resultat->dossier->id);
        return response()->json(['resultat'=>$resultat]);

    }


    public function uploadFile($request, $consultation){
        foreach ($request->documents as $document){
            $path = $document->storeAs('public/DossierMedicale/' . $consultation->dossier->numero_dossier . '/ConsultationFichier/' . $consultation->id,
                $document->getClientOriginalName());

            $file = str_replace('public/','',$path);

            $file = \App\Models\File::create([
                'fileable_type'=>'ConsultationFichier',
                'fileable_id'=>$consultation->id,
                'nom'=>$document->getClientOriginalName(),
                'extension'=>$document->getClientOriginalExtension(),
                'chemin'=>$file,
            ]);

            $this->updateDossierId($consultation->dossier->id);

        }
    }
}
