<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PraticienRequest;
use App\Models\Praticien;
use Illuminate\Support\Facades\Validator;

class PraticienController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $praticiens = Praticien::all();
        return response()->json(['praticiens'=>$praticiens]);
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
    public function store(PraticienRequest $request)
    {
        //Sauvegarde des informations personnelles
        $praticien = Praticien::create($request->validated());

        //Generation du mot de passe et envoie par mail
        $user = UserController::generatedUser(fullName($praticien),$praticien->email);
        $user->assignRole('Praticien');

        $praticien->user_id = $user->id;
        $praticien->save();

        return response()->json(['praticien'=>$praticien]);

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
        $praticien = Praticien::find($id);
        return response()->json(['praticien'=>$praticien]);

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
    public function update(PraticienRequest $request, $id)
    {
        $this->validatedId($id);
        Praticien::whereId($id)->update($request->validated());
        $praticien = Praticien::find($id);
        return response()->json(['praticien'=>$praticien]);

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
        $praticien = Praticien::find($id);
        Praticien::destroy($id);
        return response()->json(['praticien'=>$praticien]);

    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function validatedId($id){
        $validation = Validator::make(compact('id'),['id'=>'exists:praticiens,id']);
        if ($validation->fails()){
            return response()->json(['id'=>$validation->errors()],422);
        }
    }
}
