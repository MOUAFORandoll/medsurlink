<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SouscripteurStoreRequest;
use App\Http\Requests\SouscripteurUpdateRequest;
use App\Models\Souscripteur;
use Illuminate\Support\Facades\Validator;

class SouscripteurController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $souscripteurs = Souscripteur::all();
        return response()->json(['souscripteurs'=>$souscripteurs]);
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
    public function store(SouscripteurStoreRequest $request)
    {
        $souscripteur = Souscripteur::create($request->validated());
        //Calcul de l'age du souscripteur
        $age = evaluateYearOfOld($souscripteur->date_de_naissance);
        $souscripteur->age = $age;

        //Generation du mot de passe et envoie par mail
        $user = UserController::generatedUser(fullName($request),$souscripteur->email);
        $user->assignRole('Souscripteur');

        $souscripteur->user_id = $user->id;
        $souscripteur->save();

        defineAsAuthor("Souscripteur",$souscripteur->id,'create');

        return response()->json(['souscripteur'=>$souscripteur]);

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
        $souscripteur = Souscripteur::find($id);
        return response()->json(['souscripteur'=>$souscripteur]);

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
    public function update(SouscripteurUpdateRequest $request, $id)
    {
         $validation = $this->validatedId($id);
        if(!is_null($validation))
            return $validation;
        Souscripteur::whereId($id)->update($request->validated());

        //Calcul de l'age du souscripteur
        $souscripteur = Souscripteur::find($id);
        $age = evaluateYearOfOld($souscripteur->date_de_naissance);
        //ajustement de l'age du souscripteur
        $souscripteur->age = $age;
        $souscripteur->save();

        //ajustement de l'email du user
        $user = $souscripteur->user;
        $user->email = $souscripteur->email;
        $user->save();

        return response()->json(['souscripteur'=>$souscripteur]);

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
        $souscripteur = Souscripteur::find($id);
        Souscripteur::destroy($id);
        return response()->json(['souscripteur'=>$souscripteur]);

    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function validatedId($id){
        $validation = Validator::make(compact('id'),['id'=>'exists:souscripteurs,id']);
        if ($validation->fails()){
            return response()->json($validation->errors(),422);
        }
        return null;
    }
}
