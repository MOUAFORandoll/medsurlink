<?php

namespace App\Http\Controllers\Api\v1;

use Carbon\Carbon;
use App\Models\Avis;
use App\Models\Patient;
use App\Models\Affiliation;
use App\Models\Cardiologie;
use App\Models\MedecinAvis;
use Illuminate\Http\Request;
use App\Models\DossierMedical;
use App\Models\Kinesitherapie;
use App\Models\Hospitalisation;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\ConsultationObstetrique;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\DossierMedicalRequest;
use App\Models\ConsultationMedecineGenerale;
use App\Models\EtablissementExercicePatient;
use App\Models\EtablissementExercicePraticien;
use App\Http\Controllers\Traits\PersonnalErrors;
use Netpok\Database\Support\DeleteRestrictionException;

class DossierMedicalController extends Controller
{
    use PersonnalErrors;
    protected $table = 'dossier_medicals';

    /**
     * Display a listing of the resource.
     * @OA\Get(
     *      path="/dossier",
     *      operationId="getDossierMedicalList",
     *      tags={"DossierMedical"},
     *      summary="Get list of Dossier Medical",
     *      description="Return list of Dossier Medical",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     * @OA\Response(
     *      response=400,
     *      description="Bad Request"
     *   ),
     * @OA\Response(
     *      response=404,
     *      description="not found"
     *   ),
     *  )
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dossiers = DossierMedical::with([
            'allergies'=> function ($query) {
                $query->orderBy('date', 'desc');
            },
            'antecedents',
            'ordonances',
            'patient',
            'patient.user',
            'consultationsMedecine',
            'kinesitherapies',
            'consultationsObstetrique',
            'traitements'=> function ($query) {
                $query->orderBy('created_at', 'desc');
            }
        ])->latest()->paginate(15);
        foreach ($dossiers as $dossier){
            if (!is_null($dossier)){
                $dossier->updateDossier();
            }
        }
        return response()->json(['dossiers'=>$dossiers]);
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
     * @OA\Post(
     *      path="/dossier/{slug}",
     *      operationId="storeDossierMedicalList",
     *      tags={"DossierMedical"},
     * security={
     *  {"passport": {}},
     *   },
     *      summary="Store Dossier Medical",
     *      description="Store a Dossier Medical",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     * @OA\Response(
     *      response=400,
     *      description="Bad Request"
     *   ),
     * @OA\Response(
     *      response=404,
     *      description="not found"
     *   ),
     *  )
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DossierMedicalRequest $request)
    {

        $patient =Patient::with('dossier')->find($request->get('patient_id'));
        if (!is_null($patient->dossier) or !empty($patient->dossier)){
            $this->revealDuplicateDossier($patient->dossier->numero_dossier);
        }

        $numero_dossier = $this->randomNumeroDossier();
        $dossier = DossierMedical::create([
            'patient_id'=>$request->get('patient_id'),
            "date_de_creation"=>Carbon::now()->format('Y-m-d'),
            "numero_dossier"=>$numero_dossier,
        ]);

        defineAsAuthor("DossierMedical",$dossier->id,'create',$dossier->patient->user_id);

        return response()->json(['dossier'=>$dossier]);
    }

    /**
     * Display the specified resource.
     * @OA\Get(
     *      path="/dossier/{slug}",
     *      operationId="getDossierMedical",
     *      tags={"DossierMedical"},
     * security={
     *  {"passport": {}},
     *   },
     *      summary="Show Dossier Medical",
     *      description="Show a Dossier Medical",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     * @OA\Response(
     *      response=400,
     *      description="Bad Request"
     *   ),
     * @OA\Response(
     *      response=404,
     *      description="not found"
     *   ),
     *  )
     * @param $slug
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function show($slug)
    {
        // $this->validatedSlug($slug,$this->table);
        $validation = validatedSlug($slug,$this->table);
        // if(!is_null($validation))
        //     return $validation;

                 $dossier = DossierMedical::with([
                'allergies'=> function ($query) {
                    $query->orderBy('date', 'desc');
                },
                'antecedents',
                'comptesRenduOperatoire.etablissement',
                'ordonances',
                'patient',
                'avis',
                'financeurs.financable',
                'patient.user',
                'patient.medecinReferent.medecinControles.user',
                'patient.souscripteur.user',
                'consultationsMedecine',
                'consultationsObstetrique',
                'consultationsObstetrique.echographies',
                'hospitalisations'=> function ($query) {
                    $query->orderBy('created_at', 'desc');
                },
                'traitements'=> function ($query) {
                    $query->orderBy('created_at', 'desc');
                },
                'resultatsImagerie',
                'kinesitherapies.etablissement',
                'kinesitherapies.author',
                'resultatsLabo',
                'cardiologies',
                     'consultationsManuscrites.praticien',
                     'consultationsManuscrites.etablissement',
            ])->whereSlug($slug,$this->table)->first();

            if (!is_null($dossier)) {
                $dossier->updateDossier();
            }
            $affiliation = Affiliation::with(['package'])->where('patient_id',$dossier->patient->user->id )->get();
            $contrat = getContrat($dossier->patient->user);
            $dossier->affiliation = $affiliation;
            $this->checkIfUserAuthorized($dossier);
            // dd($dossier->consultationsMedecine);

            foreach($dossier->consultationsMedecine as $i => $consultation){
                $consultation->examens = is_array($consultation->examens) ? $consultation->examens : json_decode($consultation->examens);
                $dossier->consultationsMedecine[$i] = $consultation;
            }
           
       return response()->json(['dossier'=>$dossier, 'affiliation'=>$affiliation, 'cim'=>$contrat ]);
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
     * Display the specified resource.
     * @OA\Delete(
     *      path="/dossier/{slug}",
     *      operationId="deleteDossierMedical",
     *      tags={"DossierMedical"},
     * security={
     *  {"passport": {}},
     *   },
     *      summary="Delete Dossier Medical",
     *      description="Delete a Dossier Medical",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     * @OA\Response(
     *      response=400,
     *      description="Bad Request"
     *   ),
     * @OA\Response(
     *      response=404,
     *      description="not found"
     *   ),
     *  )
     * @param $slug
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function destroy($slug)
    {
        $this->validatedSlug($slug,$this->table);

        try{
            $dossier = DossierMedical::with([
                'allergies'=> function ($query) {
                    $query->orderBy('created_at', 'desc');
                },
                'patient',
                'consultationsMedecine',
                'consultationsObstetrique'])->whereSlug($slug)->first();
            $dossier->delete();
            $patient = Patient::where('user_id','=',$dossier->patient_id)->first();
            $patient->delete();

            defineAsAuthor("DossierMedical",$dossier->id,'delete',$dossier->patient->user_id);
            defineAsAuthor("Patient",$dossier->id,'delete',$dossier->patient->user_id);

            return response()->json(['dossier'=>$dossier]);
        }catch (DeleteRestrictionException $deleteRestrictionException){
            $this->revealError('deletingError',$deleteRestrictionException->getMessage());
        }
    }


    public static function randomNumeroDossier(){
        $resultat = ''.rand(0,99999999);
        while (strlen($resultat)<8){
            $longueur = strlen($resultat);
            if ($longueur == 1)
                $resultat = $resultat.''.rand(0,9999999);
            elseif ($longueur == 2 )
                $resultat = $resultat.''.rand(0,999999);
            elseif ($longueur == 3 )
                $resultat = $resultat.''.rand(0,99999);
            elseif ($longueur == 4 )
                $resultat = $resultat.''.rand(0,9999);
            elseif ($longueur == 5 )
                $resultat = $resultat.''.rand(0,999);
            elseif ($longueur == 6 )
                $resultat = $resultat.''.rand(0,99);
            elseif ($longueur == 7 )
                $resultat = $resultat.''.rand(0,9);

        }

        while(count(DossierMedical::where('numero_dossier','=',$resultat)->latest()->get())>0){
            $resultat = self::randomNumeroDossier();
        }

        return $resultat;
    }

    public static function genererDossier($patientId){
        $numero_dossier = self::randomNumeroDossier();
        $dossier = DossierMedical::create([
            'patient_id'=>$patientId,
            "date_de_creation"=>Carbon::now()->format('Y-m-d'),
            "numero_dossier"=>$numero_dossier,
        ]);

        return response()->json(['dossier'=>$dossier]);
    }


    public function dossierByPatientId($patient_id){
        $validator = Validator::make(compact('patient_id'),'exists:dossier_medicals,patient_id');
        if ($validator->fails()){
            return response()->json(compact($validator->errors()->getMessages()),422);
        }

        $dossier = DossierMedical::with([
            'allergies'=> function ($query) {
                $query->orderBy('date', 'desc');
            },
            'antecedents',
            'patient',
            'ordonances',
            'consultationsMedecine',
            'kinesitherapies',
            'consultationsObstetrique',
            'consultationsObstetrique.echographies',
            'hospitalisations'=> function ($query) {
                $query->orderBy('created_at', 'desc');
            },
            'traitements'=> function ($query) {
                $query->orderBy('created_at', 'desc');
            },
            'resultatsImagerie',
            'resultatsLabo'
        ])->where('patient_id' ,'=',$patient_id)->first();

        if (!is_null($dossier)) {
            $dossier->updateDossier();
        }

        return response()->json(['dossier'=>$dossier]);
    }

    public function dossierMyPatient(){

        $dossiers = Array(
            'consultationsMedecine'=>
              ConsultationMedecineGenerale::where('creator','=',Auth::id())->with('dossier.patient.user')->latest()->get(),
            'hospitalisations'=>
                Hospitalisation::where('creator','=',Auth::id())->with('dossier.patient.user')->latest()->get(),
            'cardiologies'=>
                Cardiologie::where('creator','=',Auth::id())->with('dossier.patient.user')->latest()->get(),
            'kinesitherapies'=>
                Kinesitherapie::where('creator','=',Auth::id())->with('dossier.patient.user')->latest()->get(),
            'consultationsObstetrique'=>
                ConsultationObstetrique::where('creator','=',Auth::id())->with('dossier.patient.user')->latest()->get(),
            'avis'=> Avis::where('creator','=',Auth::id())->with('dossier.patient.user')->latest()->get(),
            'mesAvis'=>MedecinAvis::with([
                    'avisMedecin.dossier.patient.user',
                ])->where('medecin_id','=',Auth::id())->latest()->get(),
        );
        return response()->json(['dossiers'=>$dossiers]);
    }

    public function dossierMyPatientSpecial($value){
        $result=Array(
            'consultationsMedecine'=>[],
            'hospitalisations'=>[],
            'cardiologies'=>[],
            'kinesitherapies'=>[],
            'consultationsObstetrique'=>[],
            'avis'=>[],
            'mesAvis'=>[]);
        $dossiers = Array(
            'consultationsMedecine'=>
              ConsultationMedecineGenerale::where('creator','=',Auth::id())->with('dossier.patient.user')->latest()->get(),
            'hospitalisations'=>
                Hospitalisation::where('creator','=',Auth::id())->with('dossier.patient.user')->latest()->get(),
            'cardiologies'=>
                Cardiologie::where('creator','=',Auth::id())->with('dossier.patient.user')->latest()->get(),
            'kinesitherapies'=>
                Kinesitherapie::where('creator','=',Auth::id())->with('dossier.patient.user')->latest()->get(),
            'consultationsObstetrique'=>
                ConsultationObstetrique::where('creator','=',Auth::id())->with('dossier.patient.user')->latest()->get(),
            'avis'=> Avis::where('creator','=',Auth::id())->with('dossier.patient.user')->latest()->get(),
            'mesAvis'=>MedecinAvis::with([
                    'avisMedecin.dossier.patient.user',
                ])->where('medecin_id','=',Auth::id())->latest()->get(),
        );
        // return $dossiers;
        foreach($dossiers['consultationsMedecine'] as $p){
            if($p->dossier->patient->user!=null){
                if(strpos(strtolower($p->dossier->patient->user->nom),strtolower($value))!==false ||
            strpos(strtolower($p->dossier->patient->user->prenom),strtolower($value))!==false ||
            strpos(strtolower($p->dossier->patient->user->email),strtolower($value))!==false)
            array_push($result['consultationsMedecine'],$p);
            }
            else{
                if(strpos(strtolower(strval($p->dossier->numero_dossier)),strtolower($value))!==false ||
                strpos(strtolower(strval($p->dossier->patient->age)),strtolower($value))!==false)
                array_push($result['consultationsMedecine'],$p);
            }

        }
        foreach($dossiers['hospitalisations'] as $p){
            if($p->dossier->patient->user!=null){
                if(strpos(strtolower($p->dossier->patient->user->nom),strtolower($value))!==false ||
            strpos(strtolower($p->dossier->patient->user->prenom),strtolower($value))!==false ||
            strpos(strtolower($p->dossier->patient->user->email),strtolower($value))!==false)
            array_push($result['hospitalisations'],$p);
            }
            else{
                if(strpos(strtolower(strval($p->dossier->numero_dossier)),strtolower($value))!==false ||
                strpos(strtolower(strval($p->dossier->patient->age)),strtolower($value))!==false)
                array_push($result['hospitalisations'],$p);
            }

        }
        foreach($dossiers['cardiologies'] as $p){
            if($p->dossier->patient->user!=null){
                if(strpos(strtolower($p->dossier->patient->user->nom),strtolower($value))!==false ||
            strpos(strtolower($p->dossier->patient->user->prenom),strtolower($value))!==false ||
            strpos(strtolower($p->dossier->patient->user->email),strtolower($value))!==false)
            array_push($result['cardiologies'],$p);
            }
            else{
                if(strpos(strtolower(strval($p->dossier->numero_dossier)),strtolower($value))!==false ||
                strpos(strtolower(strval($p->dossier->patient->age)),strtolower($value))!==false)
                array_push($result['cardiologies'],$p);
            }

        }
        foreach($dossiers['kinesitherapies'] as $p){
            if($p->dossier->patient->user!=null){
                if(strpos(strtolower($p->dossier->patient->user->nom),strtolower($value))!==false ||
            strpos(strtolower($p->dossier->patient->user->prenom),strtolower($value))!==false ||
            strpos(strtolower($p->dossier->patient->user->email),strtolower($value))!==false)
            array_push($result['kinesitherapies'],$p);
            }
            else{
                if(strpos(strtolower(strval($p->dossier->numero_dossier)),strtolower($value))!==false ||
                strpos(strtolower(strval($p->dossier->patient->age)),strtolower($value))!==false)
                array_push($result['kinesitherapies'],$p);
            }

        }
        foreach($dossiers['consultationsObstetrique'] as $p){
            if($p->dossier->patient->user!=null){
                if(strpos(strtolower($p->dossier->patient->user->nom),strtolower($value))!==false ||
            strpos(strtolower($p->dossier->patient->user->prenom),strtolower($value))!==false ||
            strpos(strtolower($p->dossier->patient->user->email),strtolower($value))!==false)
            array_push($result['consultationsObstetrique'],$p);
            }
            else{
                if(strpos(strtolower(strval($p->dossier->numero_dossier)),strtolower($value))!==false ||
                strpos(strtolower(strval($p->dossier->patient->age)),strtolower($value))!==false)
                array_push($result['consultationsObstetrique'],$p);
            }

        }
        foreach($dossiers['avis'] as $p){
            if($p->dossier->patient->user!=null){
                if(strpos(strtolower($p->dossier->patient->user->nom),strtolower($value))!==false ||
            strpos(strtolower($p->dossier->patient->user->prenom),strtolower($value))!==false ||
            strpos(strtolower($p->dossier->patient->user->email),strtolower($value))!==false)
            array_push($result['avis'],$p);
            }
            else{
                if(strpos(strtolower(strval($p->dossier->numero_dossier)),strtolower($value))!==false ||
                strpos(strtolower(strval($p->dossier->patient->age)),strtolower($value))!==false)
                array_push($result['avis'],$p);
            }

        }
        foreach($dossiers['mesAvis'] as $p){
            if($p->dossier->patient->user!=null){
                if(strpos(strtolower($p->dossier->patient->user->nom),strtolower($value))!==false ||
            strpos(strtolower($p->dossier->patient->user->prenom),strtolower($value))!==false ||
            strpos(strtolower($p->dossier->patient->user->email),strtolower($value))!==false)
            array_push($result['mesAvis'],$p);
            }
            else{
                if(strpos(strtolower(strval($p->dossier->numero_dossier)),strtolower($value))!==false ||
                strpos(strtolower(strval($p->dossier->patient->age)),strtolower($value))!==false)
                array_push($result['mesAvis'],$p);
            }

        }
        return response()->json(['dossiers'=>$result]);
    }

    public function checkIfUserAuthorized(DossierMedical $dossier)
    {
        $patientEtablissementId = EtablissementExercicePatient::where('patient_id', '=', $dossier->patient->user_id)->get('id');
        $user = \App\User::with(['praticien'])->whereId(Auth::id())->first();
        //Recuperation des etablissements du praticien
        if (!is_null($user->praticien)) {
            $etablissementsCount = EtablissementExercicePraticien::whereIn('etablissement_id', $patientEtablissementId)->count();
            if ($etablissementsCount == 0){
                defineAsAuthor("DossierMedical",$dossier->id,'accès non autorisé',$dossier->patient->user_id);
            }
        }
    }

    public function consultationsMedecines($dossier_slug){
        $dossier =  DossierMedical::whereSlug($dossier_slug)->first();
        $consultattion_generales = $dossier->consultationsMedecine()->latest()->get();
       return response()->json(['consultattion_generales' => $consultattion_generales]);
    }
}
