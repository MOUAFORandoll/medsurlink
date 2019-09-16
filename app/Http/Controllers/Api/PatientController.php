<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\patientStoreRequest;
use App\Http\Requests\PatientUpdateRequest;
use App\Http\Requests\UserStoreRequest;
use App\Models\Patient;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Netpok\Database\Support\DeleteRestrictionException;

class PatientController extends Controller
{
    protected $table = 'Patients';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $patients = Patient::with(['souscripteur','dossier','user','affiliations','etablissements'])->restrictUser()->get();
        return response()->json(['patients'=>$patients]);
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
    public function store(patientStoreRequest $request)
    {

        //Creation de l'utilisateur dans la table user et génération du mot de passe
        $userResponse =  UserController::generatedUser($request);
        if ($userResponse->status() == 419)
            return $userResponse;

        $user = $userResponse->getOriginalContent()['user'];
        $password = $userResponse->getOriginalContent()['password'];
        //Attribution du rôle patient
        $user->assignRole('Patient');
        //Creation du compte patient
        $age = evaluateYearOfOld($request->date_de_naissance);
        $patient = Patient::create($request->validated() + ['user_id' => $user->id,'age'=>$age]);
        //Generation du dossier client
        $dossier = DossierMedicalController::genererDossier($patient->user_id);
        defineAsAuthor("Patient",$patient->user_id,'create');

        //Envoi des informations patient par mail
        UserController::sendUserInformationViaMail($user,$password);

        $patient = Patient::with(['dossier','affiliations'])->restrictUser()->whereSlug($patient->slug)->first();
        return response()->json(['patient'=>$patient,"password"=>$password]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $validation = $this->validatedSlug($slug);
        if(!is_null($validation))
            return $validation;

        $patient = Patient::with(['souscripteur','user','affiliations','etablissements'])->restrictUser()->whereSlug($slug)->first();
        return response()->json(['patient'=>$patient]);

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
    public function update(PatientUpdateRequest $request, $slug)
    {

        $validation = $this->validatedSlug($slug);
        if(!is_null($validation))
            return $validation;

        $age = evaluateYearOfOld($request->date_de_naissance);

        Patient::whereSlug($slug)->update($request->validated()+['age'=>$age]);
        $patient = Patient::with(['souscripteur','user','affiliations','etablissements'])->restrictUser()->whereSlug($slug)->first();

        return response()->json(['patient'=>$patient]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        $validation = $this->validatedSlug($slug);
        if(!is_null($validation))
            return $validation;

        try{
            $patient = Patient::with(['souscripteur','user','affiliations','etablissements'])->restrictUser()->whereSlug($slug)->first();
            $patient->delete();
            return response()->json(['patient'=>$patient]);
        }catch (DeleteRestrictionException $deleteRestrictionException){
            return response()->json(['error'=>$deleteRestrictionException->getMessage()],422);
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function validatedSlug($slug){
        $validation = Validator::make(compact('slug'),['slug'=>'exists:patients,slug']);
        if ($validation->fails()){
            return response()->json($validation->errors(),422);
        }
        return null;
    }
}
