<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SouscripteurStoreRequest;
use App\Http\Requests\SouscripteurUpdateRequest;
use App\Models\Souscripteur;
use Illuminate\Support\Facades\Validator;
use Netpok\Database\Support\DeleteRestrictionException;

class SouscripteurController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $souscripteurs = Souscripteur::with('patients','user')->get();
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
        //Création des informations utilisateurs
        $userResponse =  UserController::generatedUser($request);
        if ($userResponse->status() == 419)
            return $userResponse;

        $user = $userResponse->getOriginalContent()['user'];
        $password = $userResponse->getOriginalContent()['password'];
        $user->assignRole('Souscripteur');

        //Creation du compte souscripteurs
        $age = evaluateYearOfOld($request->date_de_naissance);
        array_merge($request->validated(), ['user_id' => $user->id]);
        $souscripteur = Souscripteur::create($request->validated() + ['user_id' => $user->id,'age'=>$age]);

        defineAsAuthor("Souscripteur",$souscripteur->user_id,'create');

        //envoi des informations du compte utilisateurs par mail
        UserController::sendUserInformationViaMail($user,$password);
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

        $souscripteur = Souscripteur::with('user','patients')->whereUserId($id)->first();
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

        $age = evaluateYearOfOld($request->date_de_naissance);

        Souscripteur::whereUserId($id)->update($request->validated()+['age'=>$age]);

        //Calcul de l'age du souscripteur
        $souscripteur = Souscripteur::with('user','patients')->whereUserId($id)->first();

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
        try{
            $souscripteur = Souscripteur::with('user','patients')->whereUserId($id)->first();
            $souscripteur->delete();
            return response()->json(['souscripteur'=>$souscripteur]);

        }catch (DeleteRestrictionException $deleteRestrictionException){
            return response()->json(['error'=>$deleteRestrictionException->getMessage()],422);
        }

    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function validatedId($id){
        $validation = Validator::make(compact('id'),['id'=>'exists:souscripteurs,user_id']);
        if ($validation->fails()){
            return response()->json($validation->errors(),422);
        }
        return null;
    }
}
