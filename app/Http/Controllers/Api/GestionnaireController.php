<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\GestionnaireRequest;
use App\Models\Gestionnaire;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class GestionnaireController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $gestionnaires = Gestionnaire::all();
        return response()->json(['gestionnaires'=>$gestionnaires]);
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
    public function store(GestionnaireRequest $request)
    {
        $gestionnaire = Gestionnaire::create($request->validated());

        //Generation du mot de passe et envoie par mail
        $user = UserController::generatedUser(fullName($request),$gestionnaire->email);
        $user->assignRole('Gestionnaire');

        $gestionnaire->user_id = $user->id;
        $gestionnaire->save();

        return response()->json(['gestionnaire'=>$gestionnaire]);

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
        $gestionnaire = Gestionnaire::find($id);
        return response()->json(['gestionnaire'=>$gestionnaire]);

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
    public function update(GestionnaireRequest $request, $id)
    {
        $this->validatedId($id);
        Gestionnaire::whereId($id)->update($request->validated());
        $gestionnaire = Gestionnaire::find($id);
        return response()->json(['gestionnaire'=>$gestionnaire]);

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
        $gestionnaire = Gestionnaire::find($id);
        Gestionnaire::destroy($id);
        return response()->json(['gestionnaire'=>$gestionnaire]);

    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function validatedId($id){
        $validation = Validator::make(compact('id'),['id'=>'exists:gestionnaires,id']);
        if ($validation->fails()){
            return response()->json(['id'=>$validation->errors()],422);
        }
    }
}
