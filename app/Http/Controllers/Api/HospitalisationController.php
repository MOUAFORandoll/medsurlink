<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\HospitalisationRequest;
use App\Models\Hospitalisation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HospitalisationController extends Controller
{
    protected $table = "hospitalisations";
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $hospitalisations = Hospitalisation::with(['dossier'])->get();
        return response()->json(['hospitalisations'=>$hospitalisations]);
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
    public function store(HospitalisationRequest $request)
    {
        $hospitalisation = Hospitalisation::create($request->validated());
        defineAsAuthor("Hospitalisation",$hospitalisation->id,'create');

        return response()->json(['hospitalisation'=>$hospitalisation]);

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

        $hospitalisation = Hospitalisation::with('dossier')->find($id);
        return response()->json(['hospitalisation'=>$hospitalisation]);
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
    public function update(HospitalisationRequest $request, $id)
    {
        $validation = validatedId($id,$this->table);
        if(!is_null($validation))
            return $validation;

        $isAuthor = checkIfIsAuthorOrIsAuthorized("Hospitalisation",$id,"create");
        if($isAuthor->getOriginalContent() == false){
            return response()->json(['error'=>"Vous ne pouvez modifié un élement que vous n'avez crée"],401);
        }

        Hospitalisation::whereId($id)->update($request->validated());
        $hospitalisation = Hospitalisation::with('dossier')->find($id);
        return response()->json(['hospitalisation'=>$hospitalisation]);
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

        $isAuthor = checkIfIsAuthorOrIsAuthorized("Hospitalisation",$id,"create");
        if($isAuthor->getOriginalContent() == false){
            return response()->json(['error'=>"Vous ne pouvez modifié un élement que vous n'avez crée"],401);
        }


        $hospitalisation = Hospitalisation::with('dossier')->find($id);
        Hospitalisation::destroy($id);
        return response()->json(['hospitalisation'=>$hospitalisation]);
    }
}
