<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Traits\PersonnalErrors;
use App\Http\Requests\KinesitherapieRequest;
use App\Models\EtablissementExercice;
use App\Models\Kinesitherapie;
use App\Traits\DossierTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class KinesitherapieController extends Controller
{
    use DossierTrait;
    use PersonnalErrors;
    public $table = 'kinesitherapies';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $kinesitherapies = Kinesitherapie::with(['author','operationables.contributable', 'dossier.patient.user', 'etablissement'])->orderByDateConsultation()->get();

        foreach ($kinesitherapies as $consultation) {
            $consultation->updateConsultation();
        }

        return response()->json(['kinesitherapies'=>$kinesitherapies]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(KinesitherapieRequest $request)
    {

        // Sauvegarde des informations de la consultation
        $kinesitherapie = Kinesitherapie::create(mapExpectValue($request->validated(),['contributeurs','dateRdv','motifRdv','praticien_id']));

        // Sauvegarde des contributeurs
        $contributeurs = $request->get('contributeurs');
        addContributors($contributeurs,$kinesitherapie,'Kinesitherapie');

        // Sauvegarde des fichiers
        if ($request->hasFile('documents')) {
            $documents = $request->documents;
            uploadConsultationFile($documents,$kinesitherapie,'Kinesitherapie');
        }

        // Sauvegarde des informations du rdv
        $motifRdv = $request->get('motifRdv');
        $dateRdv = $request->get('dateRdv');
        $praticien_id = praticienValidation($request->get('praticien_id'));
        bookingAppointment($kinesitherapie, 'Kinesitherapie', $motifRdv, $dateRdv, $praticien_id);

        // Ajout du patient à l'établissement si celui n'était pas encore
        updatePatientInstitution($request->get('etablissement_id'),$kinesitherapie);

        // Mise à jour dossier medical
        $this->updateDossierId($kinesitherapie->dossier->id);

        return response()->json(["kinesitherapie" => $kinesitherapie]);
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

        $kinesitherapie = Kinesitherapie::with([
            'operationables.contributable',
            'dossier.patient.user',
            'etablissement',
            'files',
            'author',
            'rdv.praticien'
        ])->whereSlug($slug)->first();

        if (!is_null($kinesitherapie)){
            $kinesitherapie->updateConsultation();
        }

        return response()->json(["kinesitherapie" => $kinesitherapie]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function update(KinesitherapieRequest $request, $slug)
    {


        $this->validatedSlug($slug,$this->table);

        $kinesitherapie = Kinesitherapie::whereSlug($slug)->first();

        if (canUpdateConsultation($kinesitherapie)){
            // Modification de la consultation

            $kinesitherapie->whereSlug($slug)->update(mapExpectValue($request->validated(),['contributeurs','dateRdv','motifRdv','praticien_id']));

            // Mise a jour de contributeurs
            $contributeurs = $request->get('contributeurs');
            updateConsultationContributors($contributeurs,$kinesitherapie,'Kinesitherapie');

            // Modification de rendez vous
            $motifRdv = $request->get('motifRdv');
            $dateRdv = $request->get('dateRdv');
            $praticien_id = praticienValidation($request->get('praticien_id'));
            updateBookingAppointment($kinesitherapie,'Kinesitherapie',$motifRdv,$dateRdv,$praticien_id);

            // Mise a jour de fichier
            if($request->hasFile('documents')){
                $documents = $request->documents;
                uploadConsultationFile($documents,$kinesitherapie);
            }

            // Mise à jour de dossier medical
            $this->updateDossierId($kinesitherapie->dossier->id);

            if (!is_null($kinesitherapie)){
                $kinesitherapie->updateConsultation();
            }

            return response()->json(["kinesitherapie" => $kinesitherapie]);
        }
        return response()->json(["kinesitherapie" => $kinesitherapie]);
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

        $kinesitherapie = Kinesitherapie::whereSlug($slug)->first();

        $kinesitherapie->delete();

        $this->updateDossierId($kinesitherapie->dossier->id);

        return response()->json(["kinesitherapie" => $kinesitherapie]);
    }

    public function archiver($slug){

        $this->validatedSlug($slug,$this->table);

        $kinesitherapie = Kinesitherapie::whereSlug($slug)->first();

        archievedConsultation($kinesitherapie);

        $kinesitherapie->updateConsultation();

        $this->updateDossierId($kinesitherapie->dossier->id);

        return response()->json(["kinesitherapie" => $kinesitherapie]);
    }

    public function transmettre($slug){

        $this->validatedSlug($slug,$this->table);

        $kinesitherapie = Kinesitherapie::whereSlug($slug)->first();

        transmitConsultation($kinesitherapie);

        $kinesitherapie->updateConsultation();

        $this->updateDossierId($kinesitherapie->dossier->id);

        return response()->json(["kinesitherapie" => $kinesitherapie]);
    }

    public function reactiver($slug){


        $this->validatedSlug($slug,$this->table);

        $kinesitherapie = Kinesitherapie::whereSlug($slug)->first();

        reactiverConsultation($kinesitherapie);

        $kinesitherapie->updateConsultation();

        $this->updateDossierId($kinesitherapie->dossier->id);

        return response()->json(["kinesitherapie" => $kinesitherapie]);
    }

}
