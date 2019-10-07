<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Traits\PersonnalErrors;
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
    use PersonnalErrors;
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
     * @param patientStoreRequest $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(patientStoreRequest $request)
    {

        //Creation de l'utilisateur dans la table user et génération du mot de passe
        $userResponse =  UserController::generatedUser($request);

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
        $this->validatedSlug($slug,$this->table);

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
     * @param PatientUpdateRequest $request
     * @param $slug
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(PatientUpdateRequest $request, $slug)
    {
        $this->validatedSlug($slug,$this->table);

        $patient= Patient::with('user')->whereSlug($slug)->first();

        UserController::updatePersonalInformation($request->except('date_de_naissance','patient','souscripteur_id','sexe'),$patient->user->slug);

        $age = evaluateYearOfOld($request->date_de_naissance);
        Patient::whereSlug($slug)->update($request->validated()+['age'=>$age]);

        $patient = Patient::with(['souscripteur','user','affiliations','etablissements'])->restrictUser()->whereSlug($slug)->first();

        return response()->json(['patient'=>$patient]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $slug
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function destroy($slug)
    {
        $this->validatedSlug($slug,$this->table);

        try{
            $patient = Patient::with(['souscripteur','user','affiliations','etablissements'])->restrictUser()->whereSlug($slug)->first();
            $patient->delete();
            return response()->json(['patient'=>$patient]);

        }catch (DeleteRestrictionException $deleteRestrictionException){
            return response()->json(['error'=>$deleteRestrictionException->getMessage()],422);
        }
    }

}
