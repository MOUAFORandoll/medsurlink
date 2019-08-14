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
        if ($request->has('error'))
        {
            return  response()->json(['error'=>$request->all()['error']],419);
        }
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
    public function show($slug)
    {
        $validation = validatedSlug($slug,$this->table);
        if(!is_null($validation))
            return $validation;

        $parametreObs = ParametreObstetrique::with(['consultationPrenatale'])->whereSlug($slug)->first();
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
    public function update(ParametreObstRequest $request, $slug)
    {
        if ($request->has('error'))
        {
            return  response()->json(['error'=>$request->all()['error']],419);
        }

        $validation = validatedSlug($slug,$this->table);
        if(!is_null($validation))
            return $validation;

        $parametreObs = ParametreObstetrique::findBySlug($slug);
        $isAuthor = checkIfIsAuthorOrIsAuthorized("ParametreObstetrique",$parametreObs->id,"create");
        if($isAuthor->getOriginalContent() == false){
            return response()->json(['error'=>"Vous ne pouvez modifié un élement que vous n'avez crée"],401);
        }

        ParametreObstetrique::whereSlug($slug)->update($request->validated());
        $parametreObs = ParametreObstetrique::with(['consultationPrenatale'])->whereSlug($slug)->first();
        return response()->json(['parametreObs'=>$parametreObs]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        $validation = validatedSlug($slug,$this->table);
        if(!is_null($validation))
            return $validation;

        $parametreObs = ParametreObstetrique::findBySlug($slug);
        $isAuthor = checkIfIsAuthorOrIsAuthorized("ParametreObstetrique",$parametreObs->id,"create");
        if($isAuthor->getOriginalContent() == false){
            return response()->json(['error'=>"Vous ne pouvez modifié un élement que vous n'avez crée"],401);
        }

        $parametreObs->delete();
        return response()->json(['parametreObs'=>$parametreObs]);
    }
}
