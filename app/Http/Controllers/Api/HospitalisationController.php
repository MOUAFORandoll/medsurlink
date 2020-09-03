<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\PersonnalErrors;
use App\Http\Requests\HospitalisationRequest;
use App\Models\Hospitalisation;
use App\Models\Motif;
use App\Models\RendezVous;
use App\Traits\DossierTrait;
use App\Traits\SmsTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class HospitalisationController extends Controller
{
    use PersonnalErrors;
    use SmsTrait;
    use DossierTrait;

    protected $table = "hospitalisations";
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $hospitalisations = Hospitalisation::with(['dossier','motifs','etablissement'])->get();

        foreach ($hospitalisations as $hospitalisation){
            $hospitalisation->updateHospitalisation();
        }

        return response()->json(['hospitalisations'=>$hospitalisations]);
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
    public function store(HospitalisationRequest $request)
    {
        $hospitalisation = Hospitalisation::create($request->except('motifRdv','rendez_vous'));
        $hospitalisation->creator = Auth::id();
        $hospitalisation->save();
        defineAsAuthor("Hospitalisation",$hospitalisation->id,'create',$hospitalisation->dossier->patient->user_id);

        //Creation du rendez vous si les information sont renseignées
        $motifRdv = $request->get('motifRdv');
        $dateRdv = $request->get('rendez_vous');
        if (!is_null($dateRdv) ){
            if (strlen($dateRdv) >0 && $dateRdv != 'null'  && $dateRdv !='Invalid date'){
                if (is_null($motifRdv) ){
                    $motifRdv = 'Rendez vous de l\'hospitalisation du '.$request->get('date_entree');
                }
                RendezVous::create([
                    "sourceable_id"=>$hospitalisation->id,
                    "sourceable_type"=>'Hospitalisation',
                    "patient_id"=>$hospitalisation->dossier->patient->user_id,
                    "praticien_id"=>Auth::id(),
                    "initiateur"=>Auth::id(),
                    "motifs"=>$motifRdv,
                    "date"=>$dateRdv,
                    "statut"=>'Programmé',
                ]);
            }
        }

        $motifs = $request->get('motifs');

        //Insertion des motifs
        foreach ($motifs as $motif){

            $converti = (integer) $motif;

            if ($converti !== 0){
                $hospitalisation->motifs()->attach($motif);
                defineAsAuthor("ConsultationMotif", $motif, 'attach',$hospitalisation->dossier->patient->user_id);
            }else{
                $item =   Motif::create([
                    "reference"=>'H'.str_random(5),
                    "description"=>$motif
                ]);

                defineAsAuthor("Motif", $item->id, 'create');
                $hospitalisation->motifs()->attach($item->id);
                defineAsAuthor("HospitalisationMotif", $item->id, 'attach',$hospitalisation->dossier->patient->user_id);

            }
        }

        $hospitalisation = Hospitalisation::with([
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
            'etablissement'
        ])->whereSlug($hospitalisation->slug)->first();
        $this->updateDossierId($hospitalisation->dossier->id);

        $this->sendSmsToUser($hospitalisation->dossier->patient->user);
        informedPatientAndSouscripteurs($hospitalisation->dossier->patient,3);

        return response()->json(['hospitalisation'=>$hospitalisation]);

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

        $hospitalisation = Hospitalisation::with([
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
            'motifs'
            ,'etablissement',
            'rdv'
        ])->whereSlug($slug)->first();
        $hospitalisation->updateHospitalisation();

        return response()->json(['hospitalisation'=>$hospitalisation]);
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
     * @param HospitalisationRequest $request
     * @param $slug
     * @return \Illuminate\Http\Response
     * @throws \App\Exceptions\PersonnnalException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(HospitalisationRequest $request, $slug)
    {
        $this->validatedSlug($slug,$this->table);

        $hospitalisation = Hospitalisation::findBySlug($slug);

        $this->checkIfAuthorized("Hospitalisation",$hospitalisation->id,"create");

        Hospitalisation::whereSlug($slug)->update($request->except('motifs','hospitalisation','motifRdv','rendez_vous'));

        $hospitalisation = Hospitalisation::with([
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
            'motifs'
            ,'etablissement'
        ])->whereSlug($slug)->first();


        //Creation du rendez vous si les information sont renseignées
        $motifRdv = $request->get('motifRdv');
        $dateRdv = $request->get('rendez_vous');

        //je récupère le rendez vous de la consultation si cela existe
        $rdv = RendezVous::where('sourceable_id',$hospitalisation->id)
            ->where('sourceable_type','Hospitalisation')
            ->first();
        if (is_null($rdv)) {
            if (!is_null($dateRdv)) {
                if (strlen($dateRdv) > 0 && $dateRdv != 'null'  && $dateRdv!='Invalid date') {
                    if (is_null($motifRdv)) {
                        $motifRdv = 'Rendez vous de l\'hospitalisation du ' . $request->get('date_entree');
                    }
                    RendezVous::create([
                        "sourceable_id" => $hospitalisation->id,
                        "sourceable_type" => 'Hospitalisation',
                        "patient_id" => $hospitalisation->dossier->patient->user_id,
                        "praticien_id" => Auth::id(),
                        "initiateur" => Auth::id(),
                        "motifs" => $motifRdv,
                        "date" => $dateRdv,
                        "statut" => 'Programmé',
                    ]);
                }
            }
        }else{
            $rdv->date = $dateRdv;
            $rdv->motifs = $motifRdv;
            $rdv->statut = 'Reprogrammé';

            $rdv->save();
        }

        //Recupération des anciens motifs
        $ancienMotifs = [];
        foreach ($hospitalisation->motifs as $motif){
            array_push($ancienMotifs,$motif->id);
        }
        $motifs = $request->get('motifs');

        foreach ($ancienMotifs as $ancien){
            if (!in_array($ancien, $motifs)){
                $hospitalisation->motifs()->detach($ancien);
                defineAsAuthor("HospitalisationMotif", $ancien, 'detach',$hospitalisation->dossier->patient->user_id);
            }
        }

        foreach ($motifs as $motif){

            $converti = (integer) $motif;
            if ($converti !== 0){
                if (!in_array($motif, $ancienMotifs)) {
                    $hospitalisation->motifs()->attach($motif);
                    defineAsAuthor("HospitalisationMotif", $hospitalisation->id, 'attach and update', $hospitalisation->dossier->patient->user_id);
                }
            }else{
                $item =   Motif::create([
                    "reference"=>'H'.str_random(5),
                    "description"=>$motif
                ]);

                defineAsAuthor("Motif", $item->id, 'create');
                $hospitalisation->motifs()->attach($item->id);
                defineAsAuthor("HospitalisationMotif", $hospitalisation->id, 'attach and update',$hospitalisation->dossier->patient->user_id);

            }
        }
        $this->updateDossierId($hospitalisation->dossier->id);

        $hospitalisation->updateHospitalisation();

        return response()->json(['hospitalisation'=>$hospitalisation]);
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

        $hospitalisation = Hospitalisation::with([
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
            'motifs','etablissement'
        ])->whereSlug($slug)->first();
        $hospitalisation->updateHospitalisation();

        $this->checkIfAuthorized("Hospitalisation",$hospitalisation->id,"create");
        $this->updateDossierId($hospitalisation->dossier->id);

        $hospitalisation->delete();

        return response()->json(['hospitalisation'=>$hospitalisation]);
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

        $resultat = Hospitalisation::with([
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
            'motifs','etablissement'
        ])->whereSlug($slug)->first();
        if (is_null($resultat->passed_at)){
            $this->revealNonTransmis();

        }else{
            $resultat->archived_at = Carbon::now();
            $resultat->save();
            $this->updateDossierId($resultat->dossier->id);

            defineAsAuthor("Hospitalisation",$resultat->id,'archive');

            //Envoi du sms
//            $this->sendSmsToUser($resultat->dossier->patient->user);
            informedPatientAndSouscripteurs($resultat->dossier->patient,1);

            return response()->json(['resultat'=>$resultat]);
        }
    }

    /**
     * Passed the specified resource in storage.
     *
     * @param $slug
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function transmettre($slug)
    {
        $this->validatedSlug($slug,$this->table);

        $resultat = Hospitalisation::with([
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
            'motifs','etablissement'
        ])->whereSlug($slug)->first();

        $resultat->passed_at = Carbon::now();
        $resultat->save();
        $this->updateDossierId($resultat->dossier->id);

        defineAsAuthor("Hospitalisation",$resultat->id,'transmettre');

        //Envoi du sms
        $this->sendSmsToUser($resultat->dossier->patient->user);
        informedPatientAndSouscripteurs($resultat->dossier->patient,0);

        return response()->json(['resultat'=>$resultat]);

    }
}
