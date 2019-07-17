<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\MedecinControleRequest;
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
    function __construct()
    {
        $this->middleware(['role_or_permission:Admin|Gestionnaire|Medecin controle']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $medecins = MedecinControle::with('specialite')->get();
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
    public function store(MedecinControleRequest $request)
    {
        $medecin = MedecinControle::create($request->validated());

        //Generation du mot de passe et envoie par mail
        $user = UserController::generatedUser(fullName($request),$medecin->email);
        $user->assignRole('Medecin controle');

        $medecin->user_id = $user->id;
        $medecin->save();

        return response()->json(['medecin'=>$medecin]);

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
        $medecin = MedecinControle::with('specialite')->find($id);
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
    public function update(MedecinControleRequest $request, $id)
    {
        $this->validatedId($id);
        MedecinControle::whereId($id)->update($request->validated());
        $medecin = MedecinControle::with('specialite')->find($id);
        return response()->json(['medecin'=>$medecin]);

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
        $medecin = MedecinControle::with('specialite')->find($id);
        MedecinControle::destroy($id);
        return response()->json(['medecin'=>$medecin]);

    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function validatedId($id){
        $validation = Validator::make(compact('id'),['id'=>'exists:medecin_controles,id']);
        if ($validation->fails()){
            return response()->json(['id'=>$validation->errors()],422);
        }
    }
}
