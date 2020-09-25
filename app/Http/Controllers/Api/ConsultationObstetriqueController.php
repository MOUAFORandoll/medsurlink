<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\PersonnalErrors;
use App\Http\Requests\ConsultationObstetriqueRequest;
use App\Models\ConsultationMedecineGenerale;
use App\Models\ConsultationObstetrique;
use App\Models\RendezVous;
use App\Traits\DossierTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Netpok\Database\Support\DeleteRestrictionException;

class ConsultationObstetriqueController extends Controller
{
    use PersonnalErrors;
    use DossierTrait;

    protected $table =  "consultation_obstetriques";
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $consultationsObstetrique = ConsultationObstetrique::with(['consultationPrenatales', 'dossier'])->orderByDateDeRendezVous()->get();

        foreach ($consultationsObstetrique as $consultationObstetrique){
            $consultationObstetrique->updateObstetricConsultation();
        }

        return response()->json(['consultationsObstetrique'=>$consultationsObstetrique]);
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
     * @param ConsultationObstetriqueRequest $request
     * @return \Illuminate\Http\Response
     * @throws \App\Exceptions\PersonnnalException
     */
    public function store(ConsultationObstetriqueRequest $request)
    {

        $maxNumeroGrossesse = self::genererNumeroGrossesse($request->dossier_medical_id);
        $user = Auth::user();
        $serologie = implode(" ",$request->serologie);
        $rccs = implode(" ",$request->rcc);
        $t1 = is_null($request->get('t1')) ? 'Non spécifié': $request->get('t1');
//        if($user->hasRole('Praticien') || $user->hasRole('Medecin controle')){
//            $specialite  = '';
//            if(!is_null($user->praticien)){
//                $specialite = $user->praticien->specialite->name;
//            }
//            else{
//                $specialite = $user->medecinControle->specialite->name;
//            }
//                        if ($specialite == "Gynéco-Obstétrique"){

        $consultationObstetrique =  ConsultationObstetrique::create($request->except('serologie','rcc','t1','dateRdv','motifRdv')+['numero_grossesse'=>$maxNumeroGrossesse,'serologie'=>$serologie,'rcc'=>$rccs,'t1'=>$t1]);
        $consultationObstetrique->creator = Auth::id();
        $consultationObstetrique->save();

        defineAsAuthor("ConsultationObstetrique",$consultationObstetrique->id,'create',$consultationObstetrique->dossier->patient->user_id);

        $consultationObstetrique = ConsultationObstetrique::with([
            'consultationPrenatales',
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
        ])->whereSlug($consultationObstetrique->slug)->first();

        //Creation du rendez vous si les information sont renseignées
        $motifRdv = $request->get('motifRdv');
        $dateRdv = $request->get('dateRdv');
        if (!is_null($dateRdv) ){
            if (strlen($dateRdv) >0 && $dateRdv != 'null' ){
                if (is_null($motifRdv)){
                    $motifRdv = 'Rendez vous de la consultation Obstetrique du '.$request->get('date_creation');
                }
                RendezVous::create([
                    "sourceable_id"=>$consultationObstetrique->id,
                    "sourceable_type"=>'ConsultationObstetrique',
                    "patient_id"=>$consultationObstetrique->dossier->patient->user_id,
                    "praticien_id"=>Auth::id(),
                    "initiateur"=>Auth::id(),
                    "motifs"=>$motifRdv,
                    "date"=>$dateRdv,
                    "statut"=>'Programmé',
                ]);
            }
        }
        $this->updateDossierId($consultationObstetrique->dossier->id);


        return response()->json(['consultationObstetrique'=>$consultationObstetrique]);

//            }else{
//                $this->revealAccesRefuse();
//            }
//        }elseif($user->hasRole('Admin')){
//            $consultationObstetrique =  ConsultationObstetrique::create($request->except('serologie')+['numero_grossesse'=>$maxNumeroGrossesse,'serologie'=>$serologie]);
//
//            defineAsAuthor("ConsultationObstetrique",$consultationObstetrique->id,'create',$consultationObstetrique->dossier->patient->user_id);
//
//            $consultationObstetrique = ConsultationObstetrique::with([
//                'consultationPrenatales',
//                'dossier',
//                'dossier.allergies',
//                'dossier.antecedents',
//                'dossier.resultatsLabo',
//                'dossier.hospitalisations',
//                'dossier.consultationsObstetrique',
//                'dossier.consultationsMedecine',
//                'dossier.resultatsImagerie',
//                'dossier.allergies',
//                'dossier.antecedents',
//                'dossier.traitements',
//            ])->whereSlug($consultationObstetrique->slug)->first();
//
//            return response()->json(['consultationObstetrique'=>$consultationObstetrique]);
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
        $this->validatedSlug($slug,$this->table);

        $consultationObstetrique =  ConsultationObstetrique::with([
            'consultationPrenatales',
            'etablissement',
            'echographies',
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
            'rdv'
        ])->whereSlug($slug)->first();
        $consultationObstetrique->updateObstetricConsultation();

        return response()->json(['consultationObstetrique'=>$consultationObstetrique]);
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
     * @param ConsultationObstetriqueRequest $request
     * @param $slug
     * @return \Illuminate\Http\Response
     * @throws \App\Exceptions\PersonnnalException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(ConsultationObstetriqueRequest $request, $slug)
    {

        $this->validatedSlug($slug,$this->table);

        $consultationObstetrique = ConsultationObstetrique::findBySlug($slug);

        $this->checkIfCanUpdated("ConsultationObstetrique",$consultationObstetrique->id,"create");

        $numeroGrossesse = $consultationObstetrique->numero_grossesse;
        $serologie = implode(" ",$request->serologie);
        $rccs = implode(" ",$request->rcc);
        ConsultationObstetrique::whereSlug($slug)->update($request->except('serologie','rcc','consultation','dateRdv','motifRdv')+['numero_grossesse'=>$numeroGrossesse,'serologie'=>$serologie,'rcc'=>$rccs]);

        $consultationObstetrique =  ConsultationObstetrique::with(['consultationPrenatales','echographies','dossier'])->whereSlug($slug)->first();

        //Creation du rendez vous si les information sont renseignées
        $motifRdv = $request->get('motifRdv');
        $dateRdv = $request->get('dateRdv');
        if (is_null($motifRdv)){
            $motifRdv = 'Rendez vous de la consultation Obstetrique du '.$request->get('date_creation');
        }

        //je récupère le rendez vous de la consultation si cela existe
        $rdv = RendezVous::where('sourceable_id',$consultationObstetrique->id)
            ->where('sourceable_type','ConsultationObstetrique')
            ->first();
        if (is_null($rdv)) {
            if (!is_null($dateRdv)) {
                if (strlen($dateRdv) > 0 && $dateRdv != 'null') {

                    RendezVous::create([
                        "sourceable_id" => $consultationObstetrique->id,
                        "sourceable_type" => 'ConsultationObstetrique',
                        "patient_id" => $consultationObstetrique->dossier->patient->user_id,
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
        $this->updateDossierId($consultationObstetrique->dossier->id);
        return response()->json(['consultationObstetrique'=>$consultationObstetrique]);
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

        $consultationObstetrique = ConsultationObstetrique::findBySlug($slug);

        $this->checkIfAuthorized("ConsultationObstetrique",$consultationObstetrique->id,"create");

        try{
            $consultationObstetrique =  ConsultationObstetrique::with(['consultationPrenatales','echographies','dossier'])->whereSlug($slug)->first();
            $consultationObstetrique->delete();
            $this->updateDossierId($consultationObstetrique->dossier->id);
            return response()->json(['consultationObstetrique'=>$consultationObstetrique]);

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

        $resultat = ConsultationObstetrique::with(['consultationPrenatales','echographies','dossier'])->whereSlug($slug)->first();
        if (is_null($resultat->passed_at)){
            $this->revealNonTransmis();
        }else{
            $resultat->archieved_at = Carbon::now();
            $resultat->save();
            defineAsAuthor("ConsultationObstetrique",$resultat->id,'archive');
            $resultat->updateObstetricConsultation();

            informedPatientAndSouscripteurs($resultat->dossier->patient,1);
            $this->updateDossierId($resultat->dossier->id);
            //Envoi du sms
            $user = $resultat->dossier->patient->user;
            if($user->isMedicasure == '1' || $user->isMedicasure == 1 ){
                $this->sendSmsToUser($user);
            }

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

        $resultat = ConsultationObstetrique::with(['consultationPrenatales','echographies','dossier'])->whereSlug($slug)->first();
        $resultat->passed_at = Carbon::now();
        $resultat->save();
        defineAsAuthor("ConsultationObstetrique",$resultat->id,'transmettre');
        $resultat->updateObstetricConsultation();
        $this->updateDossierId($resultat->dossier->id);

        //Envoi du sms
        $user = $resultat->dossier->patient->user;
        if($user->isMedicasure == '0' || $user->isMedicasure == 0 ){
            $this->sendSmsToUser($user);
        }
//        $this->sendSmsToUser($resultat->dossier->patient->user);
        informedPatientAndSouscripteurs($resultat->dossier->patient,0);

        return response()->json(['resultat'=>$resultat]);

    }

    public function reactiver($slug)
    {
        $this->validatedSlug($slug,$this->table);

        $resultat = ConsultationObstetrique::with(['consultationPrenatales','echographies','dossier'])->whereSlug($slug)->first();
        $resultat->passed_at = null;
        $resultat->archieved_at = null;
        $resultat->save();

        defineAsAuthor("ConsultationObstetrique",$resultat->id,'reactiver');
        $resultat->updateObstetricConsultation();
        $this->updateDossierId($resultat->dossier->id);

        return response()->json(['resultat'=>$resultat]);

    }

    /**
     * @return int|mixed
     */
    public static function genererNumeroGrossesse($dossier){
        $maxConsultationObst =  DB::table('consultation_obstetriques')->where('dossier_medical_id','=',$dossier)->max('numero_grossesse');
        return $maxConsultationObst +1;
    }
}
