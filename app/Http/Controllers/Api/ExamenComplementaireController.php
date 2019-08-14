<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\ExamenComplementaireRequest;
use App\Models\ExamenComplementaire;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ExamenComplementaireController extends Controller
{
    protected $table = "examen_complementaires";
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $examensComplementaire = ExamenComplementaire::all();
        return response()->json(['examensComplementaire'=>$examensComplementaire]);
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
    public function store(ExamenComplementaireRequest $request)
    {
        if ($request->has('error'))
        {
            return  response()->json(['error'=>$request->all()['error']],419);
        }
        $examenComplementaire = ExamenComplementaire::create($request->validated());
        defineAsAuthor("ExamenComplementaire",$examenComplementaire->id,'create');

        return response()->json(['examenComplementaire'=>$examenComplementaire]);

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

        $examenComplementaire = ExamenComplementaire::whereSlug($slug)->first();
        return response()->json(['examenComplementaire'=>$examenComplementaire]);

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
    public function update(ExamenComplementaireRequest $request, $slug)
    {
        if ($request->has('error'))
        {
            return  response()->json(['error'=>$request->all()['error']],419);
        }
        $validation = validatedSlug($slug,$this->table);
        if(!is_null($validation))
            return $validation;
$examenComplementaire =ExamenComplementaire::findBySlug($slug);
        $isAuthor = checkIfIsAuthorOrIsAuthorized("ExamenComplementaire",$examenComplementaire->id,"create");
        if($isAuthor->getOriginalContent() == false){
            return response()->json(['error'=>"Vous ne pouvez modifié un élement que vous n'avez crée"],401);
        }

        ExamenComplementaire::whereSlug($slug)->update($request->validated());
        $examenComplementaire = ExamenComplementaire::whereSlug($slug)->first();
        return response()->json(['examenComplementaire'=>$examenComplementaire]);
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

        $examenComplementaire  = ExamenComplementaire::findBySlug($slug);
        $isAuthor = checkIfIsAuthorOrIsAuthorized("ExamenComplementaire",$examenComplementaire->id,"create");
        if($isAuthor->getOriginalContent() == false){
            return response()->json(['error'=>"Vous ne pouvez modifié un élement que vous n'avez crée"],401);
        }

        $examenComplementaire = ExamenComplementaire::whereSlug($slug)->first();
        $examenComplementaire->delete();
        return response()->json(['examenComplementaire'=>$examenComplementaire]);
    }
}
