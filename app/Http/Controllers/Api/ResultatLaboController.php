<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Traits\PersonnalErrors;
use App\Http\Requests\ResultatRequest;
use App\Models\ResultatLabo;
use App\Traits\DossierTrait;
use App\Traits\SmsTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ActiviteAmaPatient;
use App\Models\Affiliation;
use App\Models\ConsultationMedecineGenerale;
use App\Models\DelaiOperation;
use App\Models\DossierMedical;
use App\Models\LigneDeTemps;
use App\User;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ResultatLaboController extends Controller
{
    use PersonnalErrors;
    use SmsTrait;
    use DossierTrait;

    protected $table = "resultat_labos";

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $resultats = ResultatLabo::with(['dossier', 'consultation'])->get();

        return response()->json([
            'resultats' => $resultats
        ]);
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
     * @param ResultatRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ResultatRequest $request)
    {
        $consultation_medecine_generale = ConsultationMedecineGenerale::latest()->where('dossier_medical_id', $request->dossier_medical_id)->first();
        $dossier = DossierMedical::find($request->dossier_medical_id);
        $delai_operation = DelaiOperation::latest()->where('patient_id', $dossier->patient_id)->first();

        $ama_activity = ActiviteAmaPatient::where("patient_id", $dossier->patient_id)->latest()->first();
        $affiliation = Affiliation::where("patient_id", $dossier->patient_id)->latest()->first();
        $ligne_temps = LigneDeTemps::where('dossier_medical_id', $dossier->id)->latest()->first();
        $user = User::find($dossier->patient_id);
        foreach(json_decode($request->activity_id) as $activity_id){
            $activite = ActiviteAmaPatient::create([
                'activite_ama_id' => $activity_id->id,
                'date_cloture' => $request->date,
                'affiliation_id' => $affiliation ? $affiliation->id : null,
                'commentaire' => "Ajout des résultats de laboratoire du patient {$user->name}",
                'ligne_temps_id' => $ligne_temps ? $ligne_temps->id : null,
                'patient_id' => $dossier->patient_id,
                'etablissement_id' => $request->etablissement_id,
                'statut' => $request->statut,
            ]);
        }

        if($request->hasFile('file')) {
            if ($request->file('file')->isValid()) {
                $resultat = ResultatLabo::create($request->validated());

                $this->uploadFile($request,$resultat);
                $this->updateDossierId($resultat->dossier->id);
                defineAsAuthor("ResultatLabo", $resultat->id,'create',$resultat->dossier->patient->user_id);

                if(!is_null($delai_operation)){
                    DelaiOperation::create(
                        [
                            "patient_id" => $resultat->dossier->patient_id,
                            "delai_operationable_id" => $resultat->id,
                            "delai_operationable_type" => ResultatLabo::class,
                            "date_heure_prevue" => $delai_operation->created_at,
                            "date_heure_effectif" => $resultat->created_at,
                            "observation" => "RAS"
                        ]
                    );
                }elseif(!is_null($consultation_medecine_generale)){
                    DelaiOperation::create(
                        [
                            "patient_id" => $resultat->dossier->patient_id,
                            "delai_operationable_id" => $resultat->id,
                            "delai_operationable_type" => ResultatLabo::class,
                            "date_heure_prevue" => $consultation_medecine_generale->created_at,
                            "date_heure_effectif" => $resultat->created_at,
                            "observation" => "RAS"
                        ]
                    );
                }elseif(!is_null($dossier)){
                    DelaiOperation::create(
                        [
                            "patient_id" => $resultat->dossier->patient_id,
                            "delai_operationable_id" => $resultat->id,
                            "delai_operationable_type" => ResultatLabo::class,
                            "date_heure_prevue" => $dossier->updated_at,
                            "date_heure_effectif" => $resultat->created_at,
                            "observation" => "RAS"
                        ]
                    );
                }

                return response()->json([
                    'resultat' => $resultat
                ]);
            }

            return response()->json(
                [
                    'file' => 'File is not valid'
                ],
                422
            );
        }else{
            $resultat = ResultatLabo::create($request->validated());
            $this->updateDossierId($resultat->dossier->id);
            defineAsAuthor("ResultatLabo", $resultat->id,'create',$resultat->dossier->patient->user_id);
            DelaiOperation::create(
                [
                    "patient_id" => $resultat->dossier->patient_id,
                    "delai_operationable_id" => $resultat->id,
                    "delai_operationable_type" => ResultatLabo::class,
                    "date_heure_prevue" => $consultation_medecine_generale->created_at,
                    "date_heure_effectif" => $resultat->created_at,
                    "observation" => "RAS"
                ]
            );

            return response()->json([
                'resultat' => $resultat
            ]);
        }
//        else {
//            return response()->json(
//                [
//                    'file' => "File required"
//                ],
//                422
//            );
//        }
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
        $this->validatedSlug($slug, $this->table);

        $resultat = ResultatLabo::with(['dossier.patient.user','dossier.consultationsMedecine', 'consultation'])
            ->whereSlug($slug)
            ->first();
        $motifIsAuthor = checkIfIsAuthorOrIsAuthorized("ResultatLabo",$resultat->id,"create");
        $resultat['author'] = getAuthor("ResultatLabo",$resultat->id,"create");
        $resultat['isAuthor'] = $motifIsAuthor->getOriginalContent();
        $resultat->file = asset('storage/'.$resultat->file);
        return response()->json([
            'resultat' => $resultat
        ]);
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
     * @param ResultatRequest $request
     * @param $slug
     * @return \Illuminate\Http\Response
     * @throws \App\Exceptions\PersonnnalException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(ResultatRequest $request, $slug)
    {
        $this->validatedSlug($slug, $this->table);

        $resultat = ResultatLabo::findBySlug($slug);

        $this->checkIfAuthorized("ResultatLabo", $resultat->id,"create");

        ResultatLabo::whereSlug($slug)->update($request->validated());

        $resultat = ResultatLabo::with(['dossier', 'consultation'])
            ->whereSlug($slug)
            ->first();

        $file = $resultat->file;
        if($request->hasFile('file')){
            $this->uploadFile($request,$resultat);
        }

        if (!is_null($file) && $request->hasFile('file'))
            File::delete(public_path().'/storage/'.$file);

        $this->updateDossierId($resultat->dossier->id);

        return response()->json([
            'resultat' => $resultat
        ]);
    }

    /**
     * Archive the specified resource in storage.
     *
     * @param $slug
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function archive($slug)
    {
        $this->validatedSlug($slug, $this->table);

        $resultat = ResultatLabo::with(['dossier', 'consultation'])
            ->whereSlug($slug)
            ->first();

        if (is_null($resultat->passed_at)) {
            $this->revealNonTransmis();

        } else {
            $resultat->archived_at = Carbon::now();
            $resultat->save();
            $this->updateDossierId($resultat->dossier->id);
            defineAsAuthor("ResultatLabo", $resultat->id,'archive');
            //Envoi du sms
//            $this->sendSmsToUser($resultat->dossier->patient->user);
            $user = $resultat->dossier->patient->user;
            if ($user->decede == 'non') {
                informedPatientAndSouscripteurs($resultat->dossier->patient, 1);
            }
            return response()->json([
                'resultat' => $resultat
            ]);
        }
    }

    /**
     * Transmit the specified resource in storage.
     *
     * @param $slug
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function transmit($slug)
    {
        $this->validatedSlug($slug, $this->table);

        $resultat = ResultatLabo::with(['dossier', 'consultation'])
            ->whereSlug($slug)
            ->first();

        $resultat->passed_at = Carbon::now();
        $resultat->save();
        $this->updateDossierId($resultat->dossier->id);
        //Envoi du sms
        $user = $resultat->dossier->patient->user;
        if ($user->decede == 'non') {
            $this->sendSmsToUser($resultat->dossier->patient->user);
            informedPatientAndSouscripteurs($resultat->dossier->patient, 0);
        }
        return response()->json([
            'resultat' => $resultat
        ]);

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
        $validation = validatedSlug($slug, $this->table);

        if(!is_null($validation))
            return $validation;

        $resultat = ResultatLabo::with('dossier')->whereSlug($slug)->first();

        $this->checkIfAuthorized("ResultatLabo", $resultat->id,"create");
        $this->updateDossierId($resultat->dossier->id);
        $resultat->delete();
        File::delete(public_path().'/storage/'.$resultat->file);

        return response()->json([
            'resultat' => $resultat
        ]);
    }

    public function uploadFile($request, $resultat){
        if ($request->file('file')->isValid()) {
            $path = $request->file->store('public/DossierMedicale/' . $resultat->dossier->numero_dossier . '/Consultation/' . $request->consultation_medecine_generale_id);
            $file = str_replace('public/','',$path);

            $resultat->file = $file;

            $resultat->save();
        }
    }
}
