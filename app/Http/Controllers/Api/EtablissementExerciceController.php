<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\EtablissementExerciceRequest;
use App\Models\EtablissementExercice;
use Illuminate\Support\Facades\Validator;

/**
 * Class EtablissementExerciceController
 * @package App\Http\Controllers\Api
 */
class EtablissementExerciceController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $etablissements =  EtablissementExercice::all();
        return response()->json(['etablissements'=>$etablissements]);
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
    public function store(EtablissementExerciceRequest $request)
    {
        $etablissement = EtablissementExercice::create($request->validated());
        defineAsAuthor("EtablissementExercice",$etablissement->id,'create');

        return response()->json(['etablissement'=>$etablissement]);
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
            return $validation;;

        $etablissement = EtablissementExercice::find($id);
        return response()->json(['etablissement'=>$etablissement]);


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
    public function update(EtablissementExerciceRequest $request, $id)
    {
         $validation = $this->validatedId($id);
        if(!is_null($validation))
            return $validation;;

        EtablissementExercice::whereId($id)->update($request->validated());
        $etablissement = EtablissementExercice::find($id);
        return response()->json(['etablissement'=>$etablissement]);

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
            return $validation;;
        $etablissement = EtablissementExercice::find($id);
        EtablissementExercice::destroy($id);
        return response()->json(['etablissement'=>$etablissement]);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function validatedId($id){
        $validation = Validator::make(compact('id'),['id'=>'exists:etablissement_exercices,id']);
        if ($validation->fails()){
            return response()->json($validation->errors(),422);
        }
        return null;
    }
}
