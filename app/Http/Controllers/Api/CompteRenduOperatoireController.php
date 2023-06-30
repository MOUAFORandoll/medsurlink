<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\PersonnalErrors;
use App\Http\Requests\CompteRenduOperatoireRequest;
use App\Models\ActiviteAmaPatient;
use App\Models\Affiliation;
use App\Models\CompteRenduOperatoire;
use App\Models\DossierMedical;
use App\Models\LigneDeTemps;
use App\Traits\DossierTrait;
use App\Traits\SmsTrait;
use App\User;
use Carbon\Carbon;

class CompteRenduOperatoireController extends Controller
{
    use PersonnalErrors;
    use DossierTrait;
    use SmsTrait;

    /**
     * @var string
     */
    public $table = 'compte_rendu_operatoires';


    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $comptesRendu = CompteRenduOperatoire::all();
        return response()->json(['comptesRendu'=>$comptesRendu]);
    }


    /**
     * @param CompteRenduOperatoireRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CompteRenduOperatoireRequest $request)
    {
        $compteRendu = CompteRenduOperatoire::create($request->all());

        $dossier = DossierMedical::find($request->dossier_medical_id);

        $affiliation = Affiliation::where("patient_id", $dossier->patient_id)->latest()->first();
        $ligne_temps = LigneDeTemps::where('dossier_medical_id', $dossier->id)->latest()->first();
        $user = User::find($dossier->patient_id);

        foreach(json_decode($request->activity_id) as $activity_id){
            $activite = ActiviteAmaPatient::create([
                'activite_ama_id' => $activity_id->id,
                'date_cloture' => $request->date,
                'affiliation_id' => $affiliation ? $affiliation->id : null,
                'commentaire' => "Ajout du compte rendu opératoire du patient {$user->name}",
                'ligne_temps_id' => $ligne_temps ? $ligne_temps->id : null,
                'patient_id' => $dossier->patient_id,
                'etablissement_id' => $request->etablissement_id,
                'statut' => $request->statut,
            ]);
        }

        return response()->json(['compteRendu'=>$compteRendu]);
    }


    /**
     * @param string $slug
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function show($slug)
    {
        $this->validatedSlug($slug,$this->table);

        $compteRendu = CompteRenduOperatoire::with('dossier.patient.user','etablissement')->whereSlug($slug)->first();

        $compteRendu->updateCompteRendu();

        return response()->json(['compteRendu'=>$compteRendu]);
    }


    /**
     * @param CompteRenduOperatoireRequest $request
     * @param string $slug
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(CompteRenduOperatoireRequest $request, $slug)
    {
        $this->validatedSlug($slug,$this->table);

        CompteRenduOperatoire::whereSlug($slug)->update($request->except('compte_rendu_operatoire'));

        $compteRendu = CompteRenduOperatoire::whereSlug($slug)->first();

        $compteRendu->updateCompteRendu();

        return response()->json(['compteRendu'=>$compteRendu]);
    }


    /**
     * @param string $slug
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function destroy($slug)
    {
        $this->validatedSlug($slug,$this->table);

        $compteRendu = CompteRenduOperatoire::with(['dossier','createur'])->whereSlug($slug)->first();

        $compteRendu->delete();

        return response()->json(['compteRendu'=>$compteRendu]);
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

        $resultat = CompteRenduOperatoire::with(['dossier','createur'])->whereSlug($slug)->first();

        if (is_null($resultat->passed_at)){
            $this->revealNonTransmis();

        }else{
            $resultat->archieved_at = Carbon::now();
            $resultat->save();

            $user = $resultat->dossier->patient->user;
            if ($user->decede == 'non') {
                informedPatientAndSouscripteurs($resultat->dossier->patient, 1);
                $this->updateDossierId($resultat->dossier->id);

                if ($user->isMedicasure == '1' || $user->isMedicasure == 1) {
                    $this->sendSmsToUser($user);
                }
            }
            $resultat->updateCompteRendu();
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

        $resultat = CompteRenduOperatoire::with(['dossier','createur'])->whereSlug($slug)->first();
        $resultat->passed_at = Carbon::now();
        $resultat->save();

        $user = $resultat->dossier->patient->user;
        if ($user->decede == 'non') {
            if ($user->isMedicasure == '0' || $user->isMedicasure == 0) {
                $this->sendSmsToUser($user);
            }
            informedPatientAndSouscripteurs($resultat->dossier->patient, 0);
            $this->updateDossierId($resultat->dossier->id);
        }
        $resultat->updateCompteRendu();
        return response()->json(['resultat'=>$resultat]);

    }

    /**
     * @param string $slug
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function reactiver($slug)
    {
        $this->validatedSlug($slug,$this->table);

        $resultat = CompteRenduOperatoire::with(['dossier','createur'])->whereSlug($slug)->first();
        $resultat->passed_at = null;
        $resultat->archieved_at = null;
        $resultat->save();

        $this->updateDossierId($resultat->dossier->id);
        $resultat->updateCompteRendu();
        return response()->json(['resultat'=>$resultat]);

    }

}
