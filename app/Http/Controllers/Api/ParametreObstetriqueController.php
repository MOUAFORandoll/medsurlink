<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\ParametreCommunRequest;
use App\Http\Requests\ParametreObstRequest;
use App\Models\ParametreObstetrique;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ParametreObstetriqueController extends Controller
{
    protected $table = "parametre_obs";
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $parametresObs = ParametreObstetrique::with(['consultationPrenatale'])->get();
        return response()->json(['parametresObs'=>$parametresObs]);
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
    public function store(ParametreObstRequest $request)
    {
        $parametreObs = ParametreObstetrique::create($request->validated());
        defineAsAuthor("ParametreObstetrique",$parametreObs->id,'create');

        return response()->json(['parametreObs'=>$parametreObs]);
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

        $parametreObs = ParametreObstetrique::with(['consultationPrenatale'])->find($id);
        return response()->json(['parametreObs'=>$parametreObs]);

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
    public function update(ParametreObstRequest $request, $id)
    {
        $validation = validatedSlug($id,$this->table);
        if(!is_null($validation))
            return $validation;

        $isAuthor = checkIfIsAuthorOrIsAuthorized("ParametreObstetrique",$id,"create");
        if($isAuthor->getOriginalContent() == false){
            return response()->json(['error'=>"Vous ne pouvez modifié un élement que vous n'avez crée"],401);
        }

        ParametreObstetrique::whereId($id)->update($request->validated());
        $parametreObs = ParametreObstetrique::with(['consultationPrenatale'])->find($id);
        return response()->json(['parametreObs'=>$parametreObs]);
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

        $isAuthor = checkIfIsAuthorOrIsAuthorized("ParametreObstetrique",$id,"create");
        if($isAuthor->getOriginalContent() == false){
            return response()->json(['error'=>"Vous ne pouvez modifié un élement que vous n'avez crée"],401);
        }

        $parametreObs = ParametreObstetrique::with(['consultationPrenatale'])->find($id);
        ParametreObstetrique::destroy($id);
        return response()->json(['parametreObs'=>$parametreObs]);

    }
}
