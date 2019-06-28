<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\ContratIntermediationMedicaleRequest;
use App\Models\ContratIntermediationMedicale;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ContratIntermediationMedicaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $offset = $request->query('offset') != null ? $request->query('offset') : 0;
        $limit = $request->query('limit') != null ? $request->query('limit')  : 10;

        if($limit == -1) {
            $cims =   DB::table('contrat_intermediation_medicales')
                ->select(
                    "nomSouscripteur as nomS" ,
                    "paysResidenceSouscripteur as paysS",
                    "villeResidenceSouscripteur as villeS",
                    "telephoneSouscripeur1 as telephoneS1",
                    "telephoneSouscripeur2 as telephoneS2",
                    "emailSouscripteur as emailS",
                    "typeSouscription as typeSous",
                    "paysSouscription as paysSous",
                    "sexeSouscripteur as sexeS",
                    "nomPatient as nomP",
                    "prenomPatient as prenomP",
                    "sexePatient as sexeP",
                    "nomAffilie as nomA",
                    "sexeAffilie as sexeA",
                    "ageAffilie as ageA",
                    "paysResidenceAffilie as paysA",
                    "villeResidenceAffilie as villeA",
                    "telephoneAffilie1 as telephoneA1",
                    "dateNaissanceAffilie as birthdayA",
                    "telephoneAffilie2 as telephoneA2",
                    "personneContact1 as contact1",
                    "personneContact2 as contact2",
                    "nomContact",
                    "created_at",
                    "updated_at",
                    "deleted_at",
                    "montantSouscription as montantSous",
                    "dateSignature",
                    "id"
                )
                ->orderByDesc('paysA')
                ->orderByDesc('nomP')
                ->get();
        }else{

            $cims = DB::table('contrat_intermediation_medicales')
                ->select(
                    "nomSouscripteur as nomS" ,
                    "paysResidenceSouscripteur as paysS",
                    "villeResidenceSouscripteur as villeS",
                    "telephoneSouscripeur1 as telephoneS1",
                    "telephoneSouscripeur2 as telephoneS2",
                    "emailSouscripteur1 as emailS1",
                    "emailSouscripteur2 as emailS2",
                    "typeSouscription as typeSous",
                    "paysSouscription as paysSous",
                    "sexeSouscripteur as sexeS",
                    "nomPatient as nomP",
                    "prenomPatient as prenomP",
                    "sexePatient as sexeP",
                    "nomAffilie as nomA",
                    "sexeAffilie as sexeA",
                    "ageAffilie as ageA",
                    "paysResidenceAffilie as paysA",
                    "villeResidenceAffilie as villeA",
                    "telephoneAffilie1 as telephoneA1",
                    "dateNaissanceAffilie as birthdayA",
                    "telephoneAffilie2 as telephoneA2",
                    "personneContact1 as contact1",
                    "personneContact2 as contact2",
                    "nomContact",
                    "created_at",
                    "updated_at",
                    "deleted_at",
                    "dateSignature",
                    "montantSouscription as montantSous",
                    "id"
                )
                ->orderByDesc('paysA')
                ->orderByDesc('nomP')
                ->offset($offset)
                ->limit($limit)
                ->get();
        }

        return response()->json(['cims'=>$cims]);

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
    public function store(ContratIntermediationMedicaleRequest $request)
    {
        $cim = ContratIntermediationMedicale::create([
            "nomSouscripteur"=>$request->get('nomS'),
            "paysResidenceSouscripteur"=>$request->get('paysS'),
            "villeResidenceSouscripteur"=>$request->get('villeS'),
            "telephoneSouscripeur1"=>$request->get('telephoneS1'),
            "telephoneSouscripeur2"=>$request->get('telephoneS2'),
            "emailSouscripteur1"=>$request->get('emailS1'),
            "emailSouscripteur2"=>$request->get('emailS2'),
            "typeSouscription"=>$request->get('typeSous'),
            "paysSouscription"=>$request->get('paysSous'),
            "sexeSouscripteur"=>$request->get('sexeS'),
            "nomPatient"=>$request->get('nomP'),
            "prenomPatient"=>$request->get('prenomP'),
            "sexePatient"=>$request->get('sexeP'),
            "nomAffilie"=>$request->get('nomA'),
            "sexeAffilie"=>$request->get('sexeA'),
            "ageAffilie"=>$request->get('ageA'),
            "paysResidenceAffilie"=>$request->get('paysA'),
            "villeResidenceAffilie"=>$request->get('villeA'),
            "telephoneAffilie1"=>$request->get('telephoneA1'),
            "dateNaissanceAffilie"=>$request->get('birthdayA'),
            "telephoneAffilie2"=>$request->get('telephoneA2'),
            "personneContact1"=>$request->get('contact1'),
            "personneContact2"=>$request->get('contact2'),
            "nomContact"=>$request->get('nomContact'),
            "montantSouscription"=>$request->get('montantSous'),
            "lieuEtablissement"=>$request->get('lieuEtablissement'),
            "dateSignature"=>$request->get('dateSignature'),
        ]);
        $id = $cim->id;
        $cim =  $this->show($id);
        return $cim;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $validation = Validator::make(compact('id'),['id'=>'exists:contrat_intermediation_medicales,id']);

        if ($validation->fails()){
            return response()->json(['id'=>$validation->errors()],422);
        }

        $cim =  DB::table('contrat_intermediation_medicales')
            ->select(
                "nomSouscripteur as nomS" ,
                "paysResidenceSouscripteur as paysS",
                "villeResidenceSouscripteur as villeS",
                "telephoneSouscripeur1 as telephoneS1",
                "telephoneSouscripeur2 as telephoneS2",
                "emailSouscripteur1 as emailS1",
                "emailSouscripteur2 as emailS2",
                "typeSouscription as typeSous",
                "paysSouscription as paysSous",
                "sexeSouscripteur as sexeS",
                "nomPatient as nomP",
                "prenomPatient as prenomP",
                "sexePatient as sexeP",
                "nomAffilie as nomA",
                "sexeAffilie as sexeA",
                "ageAffilie as ageA",
                "paysResidenceAffilie as paysA",
                "villeResidenceAffilie as villeA",
                "telephoneAffilie1 as telephoneA1",
                "dateNaissanceAffilie as birthdayA",
                "telephoneAffilie2 as telephoneA2",
                "personneContact1 as contact1",
                "personneContact2 as contact2",
                "nomContact",
                "created_at",
                "deleted_at",
                "updated_at",
                "dateSignature",
                "lieuEtablissement",
                "montantSouscription as montantSous"
            )
            ->where('id','=',$id)
            ->get();

        return response()->json(['cim'=>$cim]);
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
    public function update(ContratIntermediationMedicaleRequest $request, $id)
    {
        $validation = Validator::make(compact('id'),['id'=>'exists:contrat_intermediation_medicales,id']);

        if ($validation->fails()){
            return response()->json(['id'=>$validation->errors()],422);
        }

        ContratIntermediationMedicale::whereId($id)->update([
            "nomSouscripteur"=>$request->get('nomS'),
            "paysResidenceSouscripteur"=>$request->get('paysS'),
            "villeResidenceSouscripteur"=>$request->get('villeS'),
            "telephoneSouscripeur1"=>$request->get('telephoneS1'),
            "telephoneSouscripeur2"=>$request->get('telephoneS2'),
            "emailSouscripteur1"=>$request->get('emailS1'),
            "emailSouscripteur2"=>$request->get('emailS2'),
            "typeSouscription"=>$request->get('typeSous'),
            "paysSouscription"=>$request->get('paysSous'),
            "sexeSouscripteur"=>$request->get('sexeS'),
            "nomPatient"=>$request->get('nomP'),
            "prenomPatient"=>$request->get('prenomP'),
            "sexePatient"=>$request->get('sexeP'),
            "nomAffilie"=>$request->get('nomA'),
            "sexeAffilie"=>$request->get('sexeA'),
            "ageAffilie"=>$request->get('ageA'),
            "paysResidenceAffilie"=>$request->get('paysA'),
            "villeResidenceAffilie"=>$request->get('villeA'),
            "telephoneAffilie1"=>$request->get('telephoneA1'),
            "telephoneAffilie2"=>$request->get('telephoneA2'),
            "dateNaissanceAffilie"=>$request->get('birthdayA'),
            "personneContact1"=>$request->get('contact1'),
            "personneContact2"=>$request->get('contact2'),
            "nomContact"=>$request->get('nomContact'),
            "montantSouscription"=>$request->get('montantSous'),
            "lieuEtablissement"=>$request->get('lieuEtablissement'),
            "dateSignature"=>$request->get('dateSignature'),
        ]);

        $cim =  $this->show($id);
        return $cim;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $validation = Validator::make(compact('id'),['id'=>'exists:contrat_intermediation_medicales,id']);

        if ($validation->fails()){
            return response()->json(['id'=>$validation->errors()],422);
        }

        $cim = $this->show($id);

        ContratIntermediationMedicale::destroy($id);

        return $cim;
    }
}
