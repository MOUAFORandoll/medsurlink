<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\GestionnaireStoreRequest;
use App\Http\Requests\GestionnaireUpdateRequest;
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
        $gestionnaires = Gestionnaire::with('user')->get();
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
    public function store(GestionnaireStoreRequest $request)
    {
        if ($request->has('error'))
        {
            return  response()->json(['error'=>$request->all()['error']],419);
        }

        //Création des informations utilisateurs
        $userResponse =  UserController::generatedUser($request);
        if ($userResponse->status() == 419)
            return $userResponse;

        $user = $userResponse->getOriginalContent()['user'];
        $password = $userResponse->getOriginalContent()['password'];
        $user->assignRole('Gestionnaire');

        $gestionnaire = Gestionnaire::create($request->validated() + ['user_id' => $user->id]);
        defineAsAuthor("Gestionnaire",$gestionnaire->user_id,'create');

        //envoi des informations du compte utilisateurs par mail
        UserController::sendUserInformationViaMail($user,$password);

        return response()->json(['gestionnaire'=>$gestionnaire]);

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
        $gestionnaire = Gestionnaire::with('user')->whereSlug($slug)->first();
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
    public function update(GestionnaireUpdateRequest $request, $slug)
    {
        if ($request->has('error'))
        {
            return  response()->json(['error'=>$request->all()['error']],419);
        }

        $validation = $this->validatedSlug($slug);
        if(!is_null($validation))
            return $validation;

        Gestionnaire::whereSlug($slug)->update($request->validated());
        $gestionnaire = Gestionnaire::with('user')->whereSlug($slug)->first();

        return response()->json(['gestionnaire'=>$gestionnaire]);

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

        $gestionnaire = Gestionnaire::whereSlug($slug)->first();
        $gestionnaire->delete();
        return response()->json(['gestionnaire'=>$gestionnaire]);

    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function validatedSlug($slug){
        $validation = Validator::make(compact('slug'),['slug'=>'exists:gestionnaires,slug']);
        if ($validation->fails()){
            return response()->json($validation->errors(),422);
        }
        return null;
    }
}
