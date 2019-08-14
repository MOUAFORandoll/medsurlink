<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\TraitementRequest;
use App\Models\Traitement;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TraitementController extends Controller
{
    protected  $table = "traitements";
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $traitements = Traitement::all();
        return response()->json(['traitements'=>$traitements]);
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
    public function store(TraitementRequest $request)
    {
        $traitement = Traitement::create($request->validated());
        defineAsAuthor("Traitement",$traitement->id,'create');
        return response()->json(['traitement'=>$traitement]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $validation = validatedSlug($id,$this->table);
        if(!is_null($validation))
            return $validation;

        $traitement = Traitement::find($id);
        return response()->json(['traitement'=>$traitement]);

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
    public function update(TraitementRequest $request, $id)
    {
        $validation = validatedSlug($id,$this->table);
        if(!is_null($validation))
            return $validation;

        $isAuthor = checkIfIsAuthorOrIsAuthorized("Resultat",$id,"create");
        if($isAuthor->getOriginalContent() == false){
            return response()->json(['error'=>"Vous ne pouvez modifié un élement que vous n'avez crée"],401);
        }

        Traitement::whereId($id)->update($request->validated());
        $traitement = Traitement::find($id);
        return response()->json(['traitement'=>$traitement]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $validation = validatedSlug($id,$this->table);
        if(!is_null($validation))
            return $validation;

        $traitement = Traitement::find($id);
        Traitement::destroy($id);
        return response()->json(['traitement'=>$traitement]);
    }
}
