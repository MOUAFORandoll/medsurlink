<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\ConsultationPrenataleRequest;
use App\Models\ConsultationPrenatale;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Netpok\Database\Support\DeleteRestrictionException;

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
        $consultationsPrenatale = ConsultationPrenatale::with(['consultationObstetrique','parametreObstetrique','examensClinique','examensComplementaire'])->get();
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
        defineAsAuthor("ConsultationPrenatale",$consultationPrenatale->id,'create');

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
        $validation = validatedSlug($id,$this->table);
        if(!is_null($validation))
            return $validation;


        $consultationPrenatale = ConsultationPrenatale::with(['consultationObstetrique','parametreObstetrique','examensClinique','examensComplementaire'])->find($id);
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
        $validation = validatedSlug($id,$this->table);
        if(!is_null($validation))
            return $validation;

        //Attachement des examens clinique

        //Attachement des examens complementaires

        //Attachement des parametres obstetrique

        ConsultationPrenatale::whereId($id)->update($request->validated());
        $consultationPrenatale = ConsultationPrenatale::with(['consultationObstetrique','parametreObstetrique','examensClinique','examensComplementaire'])->find($id);
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
        $validation = validatedSlug($id,$this->table);
        if(!is_null($validation))
            return $validation;

        $isAuthor = checkIfIsAuthorOrIsAuthorized("ConsultationPrenatale",$id,"create");
        if($isAuthor->getOriginalContent() == false){
            return response()->json(['error'=>"Vous ne pouvez modifié un élement que vous n'avez crée"],401);
        }
        try{
            $consultationPrenatale = ConsultationPrenatale::with(['consultationObstetrique','parametreObstetrique','examensClinique','examensComplementaire'])->find($id);
            ConsultationPrenatale::destroy($id);
            return response()->json(['consultationPrenatale'=>$consultationPrenatale]);
        }catch (DeleteRestrictionException $deleteRestrictionException){
            return response()->json(['error'=>$deleteRestrictionException->getMessage()],422);
        }

    }

    /**
     * Archieved the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function archiver($id)
    {
        $validation = validatedSlug($id,$this->table);
        if(!is_null($validation))
            return $validation;

        $resultat = ConsultationPrenatale::with(['consultationObstetrique','parametreObstetrique','examensClinique','examensComplementaire'])->find($id);
        if (is_null($resultat->passed_at)){
            return response()->json(['error'=>"Ce resultat n'a pas encoré été transmis"],401);
        }else{
            $resultat->archieved_at = Carbon::now();
            $resultat->save();
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
    public function transmettre($id)
    {
        $validation = validatedSlug($id,$this->table);
        if(!is_null($validation))
            return $validation;

        $resultat = ConsultationPrenatale::with(['consultationObstetrique','parametreObstetrique','examensClinique','examensComplementaire'])->find($id);
        $resultat->passed_at = Carbon::now();
        $resultat->save();

        return response()->json(['resultat'=>$resultat]);

    }
}
