<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\patientRequest;
use App\Models\Patient;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $patients = Patient::with(['souscripteur'])->get();
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
    public function store(patientRequest $request)
    {
        $patient = Patient::create($request->validated());
        //Calcul de l'age
        $age = evaluateYearOfOld($patient->date_de_naissance);
        $patient->age = $age;

        //Generation du mot de passe et envoie par mail
        $user = UserController::generatedUser(fullName($request),$patient->email);
        $user->assignRole('Medecin controle');

        $patient->user_id = $user->id;
        $patient->save();

        return response()->json(['patient'=>$patient]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->validatedId($id);
        $patient = Patient::with(['souscripteur'])->find($id);
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
    public function update(patientRequest $request, $id)
    {
        $this->validatedId($id);
        Patient::whereId($id)->update($request->validated());
        $patient = Patient::with(['souscripteur'])->find($id);
        $patient->age = evaluateYearOfOld($patient->date_de_naissance);
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
        $this->validatedId($id);
        $patient = Patient::with(['souscripteur'])->find($id);
        Patient::destroy($id);
        return response()->json(['patient'=>$patient]);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function validatedId($id){
        $validation = Validator::make(compact('id'),['id'=>'exists:patients,id']);
        if ($validation->fails()){
            return response()->json(['id'=>$validation->errors()],422);
        }
    }
}
