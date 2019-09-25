<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\MedecinControleStoreRequest;
use App\Http\Requests\MedecinControleUpdateRequest;
use App\Models\MedecinControle;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class MedecinControleController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $medecins = MedecinControle::with(['specialite','user'])->get();
        return response()->json(['medecins'=>$medecins]);
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
    public function store(MedecinControleStoreRequest $request)
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
        $user->assignRole('Medecin controle');

        $medecin = MedecinControle::create($request->validated() + ['user_id' => $user->id]);

        defineAsAuthor("MedecinControle",$medecin->user_id,'create');

        //envoi des informations du compte utilisateurs par mail
        UserController::sendUserInformationViaMail($user,$password);

        return response()->json(['medecin'=>$medecin]);

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
        $medecin = MedecinControle::with('specialite','user')->whereSlug($slug)->first();
        return response()->json(['medecin'=>$medecin]);

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
    public function update(MedecinControleUpdateRequest $request, $slug)
    {
        if ($request->has('error'))
        {
            return  response()->json(['error'=>$request->all()['error']],419);
        }

         $validation = $this->validatedSlug($slug);
        if(!is_null($validation))
            return $validation;

        $medecin= MedecinControle::with('user')->whereSlug($slug)->first();
        $user = UserController::updatePersonalInformation($request->except('civilite','specialite_id','numero_ordre','doctor'),$medecin->user->slug);
        if (array_key_exists('error',$user->getOriginalContent())){
            return response()->json(['error'=>$user->getOriginalContent()['error']],419);
        }

        MedecinControle::whereSlug($slug)->update($request->validated());
        $medecin = MedecinControle::with('specialite','user')->whereSlug($slug)->first();

//        //ajustement de l'email du user
//        $user = $medecin->user;
//        $user->email = $medecin->email;
//        $user->save();
        return response()->json(['medecin'=>$medecin]);

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
        $medecin = MedecinControle::with('specialite','user')->whereSlug($slug)->first();
        $medecin->delete();
        return response()->json(['medecin'=>$medecin]);

    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function validatedSlug($slug){
        $validation = Validator::make(compact('slug'),['slug'=>'exists:medecin_controles,slug']);
        if ($validation->fails()){
            return response()->json($validation->errors(),422);
        }
        return null;
    }
}
