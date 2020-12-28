<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\PersonnalErrors;
use App\Http\Requests\ParametreCommunRequest;
use App\Models\ParametreCommun;

class ParametreCommunController extends Controller
{
    use PersonnalErrors;
    protected  $table = "parametre_communs";
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $parametresCommun = ParametreCommun::all();

        foreach($parametresCommun as $parametreCommun){
            $parametreCommun->updateParametreCommun();
        }

        return response()->json(['parametresCommun'=>$parametresCommun]);
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
    public function store(ParametreCommunRequest $request)
    {

        $parametreCommun = ParametreCommun::create($request->validated());

        $this->updateBmi($request,$parametreCommun);

        defineAsAuthor("ParametreCommun",$parametreCommun->id,'create',$parametreCommun->consultation->dossier->patient->user_id);

        $parametreCommun = ParametreCommun::whereSlug($parametreCommun->slug)->first();

        $parametreCommun->updateParametreCommun();

        return response()->json(['parametreCommun'=>$parametreCommun]);

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

        $parametreCommun = ParametreCommun::whereSlug($slug)->first();

        $parametreCommun->updateParametreCommun();

        return response()->json(['parametreCommun'=>$parametreCommun]);

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
     * @param ParametreCommunRequest $request
     * @param $slug
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(ParametreCommunRequest $request, $slug)
    {

        $this->validatedSlug($slug,$this->table);

        $parametreCommun = ParametreCommun::findBySlug($slug);

//        $this->checkIfAuthorized("ParametreCommun",$parametreCommun->id,"create");

        ParametreCommun::whereSlug($slug)->update($request->validated());

        $parametreCommun = ParametreCommun::whereSlug($slug)->first();
        $this->updateBmi($request,$parametreCommun);

        $parametreCommun->updateParametreCommun();

        return response()->json(['parametreCommun'=>$parametreCommun]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $slug
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function destroy($slug)
    {
        $this->validatedSlug($slug,$this->table);

        $parametreCommun = ParametreCommun::whereSlug($slug)->first();
        $parametreCommun->updateParametreCommun();
        $this->checkIfAuthorized("ParametreCommun",$parametreCommun->id,"create");
        $parametreCommun->delete();

        return response()->json(['parametreCommun'=>$parametreCommun]);
    }

    public function  updateBmi($request,ParametreCommun $parametreCommun){

        if (!is_null($request->get('taille') && !is_null($request->get('poids')))){
            $tailleEnMetre = $request->get('taille') * 0.01;
            $bmi=0;
            if($tailleEnMetre!=0){
                $bmi = round((($request->get('poids'))/($tailleEnMetre * $tailleEnMetre)),2);
            }
            $parametreCommun->bmi = $bmi;
            $parametreCommun->save();
        }
    }
}
