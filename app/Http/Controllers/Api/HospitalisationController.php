<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\HospitalisationRequest;
use App\Models\Hospitalisation;
use Carbon\Carbon;

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
        $hospitalisations = Hospitalisation::with(['dossier','motifs'])->get();
        foreach ($hospitalisations as $hospitalisation){
            $user = $hospitalisation->dossier->patient->user;
            $patient = $hospitalisation->dossier->patient;
            $hospitalisation['user']=$user;
            $hospitalisation['patient']=$patient;
            $isAuthor = checkIfIsAuthorOrIsAuthorized("Hospitalisation",$hospitalisation->id,"create");
            $hospitalisation['isAuthor']=$isAuthor->getOriginalContent();
        }
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
    public function show($slug)
    {
        $validation = validatedSlug($slug,$this->table);
        if(!is_null($validation))
            return $validation;

        $hospitalisation = Hospitalisation::with(['dossier','motifs'])->whereSlug($slug)->first();
        $user = $hospitalisation->dossier->patient->user;
        $patient = $hospitalisation->dossier->patient;
        $hospitalisation['user']=$user;
        $hospitalisation['patient']=$patient;
        $isAuthor = checkIfIsAuthorOrIsAuthorized("Hospitalisation",$hospitalisation->id,"create");
        $hospitalisation['isAuthor']=$isAuthor->getOriginalContent();
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
    public function update(HospitalisationRequest $request, $slug)
    {


        $validation = validatedSlug($slug,$this->table);
        if(!is_null($validation))
            return $validation;

        $hospitalisation = Hospitalisation::findBySlug($slug);
        $isAuthor = checkIfIsAuthorOrIsAuthorized("Hospitalisation",$hospitalisation->id,"create");
        if($isAuthor->getOriginalContent() == false){
            $transmission = [];
            $transmission['accessRefuse'][0] = "Vous ne pouvez modifié un élement que vous n'avez crée";
            return response()->json(['error'=>$transmission],419 );  }

        Hospitalisation::whereSlug($slug)->update($request->validated());
        $hospitalisation = Hospitalisation::with(['dossier','motifs'])->whereSlug($slug)->first();
        $user = $hospitalisation->dossier->patient->user;
        $patient = $hospitalisation->dossier->patient;
        $hospitalisation['user']=$user;
        $hospitalisation['patient']=$patient;
        $hospitalisation['isAuthor']=$isAuthor->getOriginalContent();
        return response()->json(['hospitalisation'=>$hospitalisation]);
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
        $hospitalisation = Hospitalisation::findBySlug($slug);
        $isAuthor = checkIfIsAuthorOrIsAuthorized("Hospitalisation",$hospitalisation->id,"create");
        if($isAuthor->getOriginalContent() == false){
            $transmission = [];
            $transmission['accessRefuse'][0] = "Vous ne pouvez modifié un élement que vous n'avez crée";
            return response()->json(['error'=>$transmission],419 );
        }

        $hospitalisation->delete();
        return response()->json(['hospitalisation'=>$hospitalisation]);
    }

    /**
     * Archieved the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function archiver($slug)
    {
        $validation = validatedSlug($slug,$this->table);
        if(!is_null($validation))
            return $validation;

        $resultat = Hospitalisation::with(['dossier','motifs'])->whereSlug($slug)->first();
        if (is_null($resultat->passed_at)){
            $transmission = [];
            $transmission['nonTransmis'][0] = "Ce resultat n'a pas encoré été transmis";
            return response()->json(['error'=>$transmission],419 );
        }else{
            $resultat->archived_at = Carbon::now();
            $resultat->save();
            defineAsAuthor("Hospitalisation",$resultat->id,'archive');
            return response()->json(['resultat'=>$resultat]);
        }
    }

    /**
     * Passed the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function transmettre($slug)
    {
        $validation = validatedSlug($slug,$this->table);
        if(!is_null($validation))
            return $validation;

        $resultat = Hospitalisation::with(['dossier','motifs'])->whereSlug($slug)->first();
        $resultat->passed_at = Carbon::now();
        $resultat->save();
        defineAsAuthor("Hospitalisation",$resultat->id,'transmettre');

        return response()->json(['resultat'=>$resultat]);

    }
}
