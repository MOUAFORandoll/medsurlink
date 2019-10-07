<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\PersonnalErrors;
use App\Http\Requests\ParametreObstRequest;
use App\Models\ParametreObstetrique;

class ParametreObstetriqueController extends Controller
{
    use PersonnalErrors;
    protected $table = "parametre_obs";
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $parametresObs = ParametreObstetrique::with(['consultationPrenatale'])->get();

        foreach ($parametresObs as $parametreOb){
            $parametreOb->updateParametreObstetrique();
        }

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

        $parametreObs = ParametreObstetrique::with(['consultationPrenatale'])->whereSlug($parametreObs->slug)->first();

        defineAsAuthor("ParametreObstetrique",$parametreObs->id,'create');

        return response()->json(['parametreObs'=>$parametreObs]);
    }

    /**
     * Display the specified resource.
     *
     * @param $slug
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function show($slug)
    {
        $this->validatedSlug($slug,$this->table);

        $parametreObs = ParametreObstetrique::with(['consultationPrenatale'])->whereSlug($slug)->first();

        $parametreObs->updateParametreObstetrique();

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
     * @param ParametreObstRequest $request
     * @param $slug
     * @return \Illuminate\Http\Response
     * @throws \App\Exceptions\PersonnnalException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(ParametreObstRequest $request, $slug)
    {

        $this->validatedSlug($slug,$this->table);

        $parametreObs = ParametreObstetrique::findBySlug($slug);

        $this->checkIfAuthorized("ParametreObstetrique",$parametreObs->id,"create");

        ParametreObstetrique::whereSlug($slug)->update($request->validated());

        $parametreObs = ParametreObstetrique::with(['consultationPrenatale'])->whereSlug($slug)->first();

        return response()->json(['parametreObs'=>$parametreObs]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $slug
     * @return \Illuminate\Http\Response
     * @throws \App\Exceptions\PersonnnalException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function destroy($slug)
    {
        $this->validatedSlug($slug,$this->table);

        $parametreObs = ParametreObstetrique::findBySlug($slug);

        $this->checkIfAuthorized("ParametreObstetrique",$parametreObs->id,"create");

        $parametreObs->delete();

        return response()->json(['parametreObs'=>$parametreObs]);
    }
}
