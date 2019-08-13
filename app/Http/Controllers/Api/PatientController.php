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
        $patients = Patient::with(['souscripteur','dossier','user'])->get();
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

        $patient = Patient::with('dossier')->whereUserId($patient->user_id)->first();
        return response()->json(['patient'=>$patient,"password"=>$password]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $validation = $this->validatedId($id);
        if(!is_null($validation))
            return $validation;

        $patient = Patient::with(['souscripteur','user'])->whereUserId($id)->first();
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
    public function update(PatientUpdateRequest $request, $id)
    {
        $validation = $this->validatedId($id);
        if(!is_null($validation))
            return $validation;

        $age = evaluateYearOfOld($request->date_de_naissance);

        Patient::whereUserId($id)->update($request->validated()+['age'=>$age]);
        $patient = Patient::with(['souscripteur','user'])->whereUserId($id)->first();

//
//        //ajustement de l'email du user
//        $user = $patient->user;
//        $user->email = $patient->email;
//        $user->save();

        return response()->json(['patient'=>$patient]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $validation = $this->validatedId($id);
        if(!is_null($validation))
            return $validation;

        try{
            $patient = Patient::with(['souscripteur','user'])->whereUserId($id)->first();
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
    public function validatedId($id){
        $validation = Validator::make(compact('id'),['id'=>'exists:patients,user_id']);
        if ($validation->fails()){
            return response()->json($validation->errors(),422);
        }
        return null;
    }
}
