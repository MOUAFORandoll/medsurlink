<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ConsultationPrenataleRequest;
use App\Models\ConsultationPrenatale;
use Carbon\Carbon;
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
        $consultationsPrenatale = ConsultationPrenatale::with(['consultationObstetrique','parametresObstetrique'])->get();
        foreach ($consultationsPrenatale as $consultationPrenatale){
                $dossier = $consultationPrenatale->consultationObstetrique->dossier;
                $user = $dossier->patient->user;
                $consultationPrenatale['user']=$user;
                $consultationPrenatale['dossier']=$dossier;
            $isAuthor = checkIfIsAuthorOrIsAuthorized("ConsultationPrenatale",$consultationPrenatale->id,"create");
            $consultationPrenatale['isAuthor']=$isAuthor->getOriginalContent();
        }
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

        defineAsAuthor("ConsultationPrenatale",$consultationPrenatale->id,'create');
        $consultationPrenatale = ConsultationPrenatale::with(['consultationObstetrique','parametresObstetrique'])->whereSlug($consultationPrenatale->slug)->first();
        $user = $consultationPrenatale->consultationObstetrique->dossier->patient->user;
        $dossier = $consultationPrenatale->consultationObstetrique->dossier;
        $consultationPrenatale['user']=$user;
        $consultationPrenatale['dossier']=$dossier;
        return response()->json(['consultationPrenatale'=>$consultationPrenatale]);
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


        $consultationPrenatale = ConsultationPrenatale::with(['consultationObstetrique','parametresObstetrique'])->whereSlug($slug)->first();
        $user = $consultationPrenatale->consultationObstetrique->dossier->patient->user;
        $dossier = $consultationPrenatale->consultationObstetrique->dossier;
        $consultationPrenatale['user']=$user;
        $consultationPrenatale['dossier']=$dossier;
        $isAuthor = checkIfIsAuthorOrIsAuthorized("ConsultationPrenatale",$consultationPrenatale->id,"create");
        $consultationPrenatale['isAuthor']=$isAuthor->getOriginalContent();
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
    public function update(ConsultationPrenataleRequest $request, $slug)
    {


        $validation = validatedSlug($slug,$this->table);
        if(!is_null($validation))
            return $validation;

        //Attachement des parametres obstetrique

        ConsultationPrenatale::whereSlug($slug)->update($request->validated());
        $consultationPrenatale = ConsultationPrenatale::with(['consultationObstetrique','parametresObstetrique'])->whereSlug($slug)->first();
        $user = $consultationPrenatale->consultationObstetrique->dossier->patient->user;
        $dossier = $consultationPrenatale->consultationObstetrique->dossier;
        $consultationPrenatale['user']=$user;
        $consultationPrenatale['dossier']=$dossier;
        $isAuthor = checkIfIsAuthorOrIsAuthorized("ConsultationPrenatale",$consultationPrenatale->id,"create");
        $consultationPrenatale['isAuthor']=$isAuthor->getOriginalContent();
        return response()->json(['consultationPrenatale'=>$consultationPrenatale]);
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

        $consultationPrenatale = ConsultationPrenatale::findBySlug($slug);
        $isAuthor = checkIfIsAuthorOrIsAuthorized("ConsultationPrenatale",$consultationPrenatale->id,"create");
        if($isAuthor->getOriginalContent() == false){
            $transmission = [];
            $transmission['accessRefuse'][0] = "Vous ne pouvez modifié un élement que vous n'avez crée";
            return response()->json(['error'=>$transmission],419 ); }
        try{
            $consultationPrenatale = ConsultationPrenatale::with(['consultationObstetrique','parametresObstetrique'])->whereSlug($slug)->first();
            $consultationPrenatale->delete();
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
    public function archiver($slug)
    {
        $validation = validatedSlug($slug,$this->table);
        if(!is_null($validation))
            return $validation;

        $resultat = ConsultationPrenatale::with(['consultationObstetrique','parametresObstetrique'])->whereSlug($slug)->first();
        if (is_null($resultat->passed_at)){
            $transmission = [];
            $transmission['nonTransmis'][0] = "Ce resultat n'a pas encoré été transmis";
            return response()->json(['error'=>$transmission],419 );
        }else{
            $resultat->archieved_at = Carbon::now();
            $resultat->save();
            $user = $resultat->consultationObstetrique->dossier->patient->user;
            $dossier = $resultat->consultationObstetrique->dossier;
            $resultat['user']=$user;
            $resultat['dossier']=$dossier;
            $isAuthor = checkIfIsAuthorOrIsAuthorized("ConsultationPrenatale",$resultat->id,"create");
            $resultat['isAuthor']=$isAuthor->getOriginalContent();
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

        $resultat = ConsultationPrenatale::with(['consultationObstetrique','parametresObstetrique'])->whereSlug($slug)->first();
        $resultat->passed_at = Carbon::now();
        $resultat->save();
        $user = $resultat->consultationObstetrique->dossier->patient->user;
        $dossier = $resultat->consultationObstetrique->dossier;
        $resultat['user']=$user;
        $resultat['dossier']=$dossier;
        $isAuthor = checkIfIsAuthorOrIsAuthorized("ConsultationPrenatale",$resultat->id,"create");
        $resultat['isAuthor']=$isAuthor->getOriginalContent();
        return response()->json(['resultat'=>$resultat]);

    }
}
