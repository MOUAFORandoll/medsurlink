<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\ParametreCommunRequest;
use App\Models\ParametreCommun;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ParametreCommunController extends Controller
{
    protected  $table = "parametre_communs";
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $parametresCommun = ParametreCommun::with('consultation')->get();
        foreach($parametresCommun as $item){
            $isAuthor = checkIfIsAuthorOrIsAuthorized("ParametreCommun",$item->id,"create");
            $item['isAuthor'] = $isAuthor->getOriginalContent();
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
        if (!is_null($request->get('taille') && !is_null($request->get('poids')))){
            $tailleEnMetre = $request->get('taille') * 0.01;
            $bmi = round((($request->get('poids'))/($tailleEnMetre * $tailleEnMetre)),2);
            $parametreCommun->bmi = $bmi;
            $parametreCommun->save();
        }
        defineAsAuthor("ParametreCommun",$parametreCommun->id,'create');
        return response()->json(['parametreCommun'=>$parametreCommun]);

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

        $parametreCommun = ParametreCommun::with('consultation')->whereSlug($slug)->first();
        $isAuthor = checkIfIsAuthorOrIsAuthorized("ParametreCommun",$parametreCommun->id,"create");
        $item['isAuthor'] = $isAuthor->getOriginalContent();
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
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ParametreCommunRequest $request, $slug)
    {

        $validation = validatedSlug($slug,$this->table);
        if(!is_null($validation))
            return $validation;

        $parametreCommun = ParametreCommun::findBySlug($slug);
        $isAuthor = checkIfIsAuthorOrIsAuthorized("ParametreCommun",$parametreCommun->id,"create");
        if($isAuthor->getOriginalContent() == false){
            $transmission = [];
            $transmission['accessRefuse'] = "Vous ne pouvez modifié un élement que vous n'avez crée";
            return response()->json(['error'=>$transmission],419 );  }


        ParametreCommun::whereSlug($slug)->update($request->validated());
        $parametreCommun = ParametreCommun::with('consultation')->whereSlug($slug)->first();

        if (!is_null($request->get('taille') && !is_null($request->get('poids')))){
            $tailleEnMetre = $request->get('taille') * 0.01;
            $bmi = round((($request->get('poids'))/($tailleEnMetre * $tailleEnMetre)),2);
            $parametreCommun->bmi = $bmi;
            $parametreCommun->save();
        }
        return response()->json(['parametreCommun'=>$parametreCommun]);
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

        $parametreCommun = ParametreCommun::findBySlug($slug);
        $isAuthor = checkIfIsAuthorOrIsAuthorized("ParametreCommun",$parametreCommun->id,"create");
        if($isAuthor->getOriginalContent() == false){
            $transmission = [];
            $transmission['accessRefuse'][0] = "Vous ne pouvez modifié un élement que vous n'avez crée";
            return response()->json(['error'=>$transmission],419 );}

        $parametreCommun->delete();
        return response()->json(['parametreCommun'=>$parametreCommun]);
    }
}
