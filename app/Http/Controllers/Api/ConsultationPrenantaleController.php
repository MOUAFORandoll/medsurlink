<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\ConsultationPrenataleRequest;
use App\Models\ConsultationPrenatale;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ConsultationPrenantaleController extends Controller
{
    protected  $table = "consultation_prenatales";
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $consultationsPrenatale = ConsultationPrenatale::all();
        return response()->json(['consultationsPrenatale'=>$consultationsPrenatale]);
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
    public function store(ConsultationPrenataleRequest $request)
    {
        $consultationPrenatale = ConsultationPrenatale::create($request->validated());
        //Attachement des examens clinique

        //Attachement des examens complementaires

        //Attcahement des parametres obstetrique

        return response()->json(['consultationPrenatale'=>$consultationPrenatale]);
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


        $consultationPrenatale = ConsultationPrenatale::find($id);
        return response()->json(['consultationPrenatale'=>$consultationPrenatale]);

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
    public function update(ConsultationPrenataleRequest $request, $id)
    {
        $validation = validatedId($id,$this->table);
        if(!is_null($validation))
            return $validation;

        //Attachement des examens clinique

        //Attachement des examens complementaires

        //Attachement des parametres obstetrique

        ConsultationPrenatale::whereId($id)->update($request->validated());
        $consultationPrenatale = ConsultationPrenatale::find($id);
        return response()->json(['consultationPrenatale'=>$consultationPrenatale]);
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

        //Attachement des examens clinique

        //Attachement des examens complementaires

        //Attcahement des parametres obstetrique

        $consultationPrenatale = ConsultationPrenatale::find($id);
        ConsultationPrenatale::destroy($id);
        return response()->json(['consultationPrenatale'=>$consultationPrenatale]);
    }
}
