<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\ProfessionRequest;
use App\Models\Profession;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ProfessionController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $professions = Profession::with('specialites')->get();
        return response()->json(['professions'=>$professions]);
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
    public function store(ProfessionRequest $request)
    {
        $profession = Profession::create($request->validated());
        defineAsAuthor("Profession",$profession->id,'create');

        return response()->json(['profession'=>$profession]);
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
        $profession = Profession::with('specialites')->find($id);
        return response()->json(['profession'=>$profession]);

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
    public function update(ProfessionRequest $request, $id)
    {
         $validation = $this->validatedId($id);
        if(!is_null($validation))
            return $validation;

        $isAuthor = checkIfIsAuthorOrIsAuthorized("Profession",$id,"create");
        if($isAuthor->getOriginalContent() == false){
            return response()->json(['error'=>"Vous ne pouvez modifié un élement que vous n'avez crée"],401);
        }

        Profession::whereId($id)->update($request->validated());
        $profession = Profession::with('specialites')->find($id);
        return response()->json(['profession'=>$profession]);
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

        $isAuthor = checkIfIsAuthorOrIsAuthorized("Profession",$id,"create");
        if($isAuthor->getOriginalContent() == false){
            return response()->json(['error'=>"Vous ne pouvez modifié un élement que vous n'avez crée"],401);
        }

        $profession = Profession::with('specialites')->find($id);
        if($profession->specialites->count() > 0) {
            return response()->json(['error'=>"Cet élément est lié à un autre (spécialité), Vous devez supprimer tous les elements auquel il est lié"],422);
        }
        Profession::destroy($id);
        return response()->json(['profession'=>$profession]);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function validatedId($id){
        $validation = Validator::make(compact('id'),['id'=>'exists:professions,id']);
        if ($validation->fails()){
            return response()->json($validation->errors(),422);
        }
        return null;
    }
}
