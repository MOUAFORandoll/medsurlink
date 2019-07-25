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
        $examenComplementaire = ExamenComplementaire::create($request->validated());
        return response()->json(['examenComplementaire'=>$examenComplementaire]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $validation = validatedId($id,$this->table);
        if(!is_null($validation))
            return $validation;

        $examenComplementaire = ExamenComplementaire::find($id);
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
    public function update(ExamenComplementaireRequest $request, $id)
    {
        $validation = validatedId($id,$this->table);
        if(!is_null($validation))
            return $validation;

        ExamenComplementaire::whereId($id)->update($request->validated());
        $examenComplementaire = ExamenComplementaire::find($id);
        return response()->json(['examenComplementaire'=>$examenComplementaire]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $validation = validatedId($id,$this->table);
        if(!is_null($validation))
            return $validation;

        $examenComplementaire = ExamenComplementaire::find($id);
        ExamenComplementaire::destroy($id);
        return response()->json(['examenComplementaire'=>$examenComplementaire]);
    }
}
