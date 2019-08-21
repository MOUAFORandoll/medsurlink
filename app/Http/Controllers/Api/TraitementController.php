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
        if ($request->has('error'))
        {
            return  response()->json(['error'=>$request->all()['error']],419);
        }

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
    public function show($slug)
    {
        $validation = validatedSlug($slug,$this->table);
        if(!is_null($validation))
            return $validation;

        $traitement = Traitement::findBySlug($slug);
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
    public function update(TraitementRequest $request, $slug)
    {
        if ($request->has('error'))
        {
            return  response()->json(['error'=>$request->all()['error']],419);
        }

        $validation = validatedSlug($slug,$this->table);
        if(!is_null($validation))
            return $validation;

        $traitement = Traitement::findBySlug($slug);
        $isAuthor = checkIfIsAuthorOrIsAuthorized("Traitement",$traitement->id,"create");
        if($isAuthor->getOriginalContent() == false){
            return response()->json(['error'=>"Vous ne pouvez modifié un élement que vous n'avez crée"],401);
        }

        Traitement::whereSlug($slug)->update($request->validated());
        $traitement = Traitement::findBySlug($slug);
        return response()->json(['traitement'=>$traitement]);
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

        $traitement = Traitement::findBySlug($slug);
        $traitement->delete();
        return response()->json(['traitement'=>$traitement]);
    }
}
