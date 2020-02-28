<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\PersonnalErrors;
use App\Http\Requests\ConsultationPrenataleRequest;
use App\Models\ConsultationPrenatale;
use Carbon\Carbon;
use Netpok\Database\Support\DeleteRestrictionException;

class ConsultationPrenantaleController extends Controller
{
    use PersonnalErrors;
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
            $consultationPrenatale->updatePrenatalConsultation();
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

        $consultationPrenatale = ConsultationPrenatale::with(['consultationObstetrique','parametresObstetrique'])->whereSlug($consultationPrenatale->slug)->first();
        $consultationPrenatale->updatePrenatalConsultation();

        defineAsAuthor("ConsultationPrenatale",$consultationPrenatale->id,'create',$consultationPrenatale->consultationObstetrique->dossier->patient->user_id);

        return response()->json(['consultationPrenatale'=>$consultationPrenatale]);
    }

    /**
     * Display the specified resource.
     *
     * @param $slug
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function show($slug)
    {
        $this->validatedSlug($slug,$this->table);
        $consultationPrenatale = ConsultationPrenatale::with(['consultationObstetrique','parametresObstetrique'])->whereSlug($slug)->first();
        $consultationPrenatale->updatePrenatalConsultation();
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
     * @param ConsultationPrenataleRequest $request
     * @param $slug
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(ConsultationPrenataleRequest $request, $slug)
    {


        $this->validatedSlug($slug,$this->table);
        //Attachement des parametres obstetrique

        ConsultationPrenatale::whereSlug($slug)->update($request->validated());
        $consultationPrenatale = ConsultationPrenatale::with(['consultationObstetrique','parametresObstetrique'])->whereSlug($slug)->first();
        $consultationPrenatale->updatePrenatalConsultation();
        return response()->json(['consultationPrenatale'=>$consultationPrenatale]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $slug
     * @return \Illuminate\Http\Response
     * @throws \App\Exceptions\PersonnnalException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function destroy($slug)
    {
        $this->validatedSlug($slug,$this->table);
        $consultationPrenatale = ConsultationPrenatale::findBySlug($slug);
        $isAuthor = checkIfIsAuthorOrIsAuthorized("ConsultationPrenatale",$consultationPrenatale->id,"create");
        if($isAuthor->getOriginalContent() == false){
            $this->revealAccesRefuse();
        }
        try{
            $consultationPrenatale = ConsultationPrenatale::with(['consultationObstetrique','parametresObstetrique'])->whereSlug($slug)->first();
            $consultationPrenatale->delete();
            return response()->json(['consultationPrenatale'=>$consultationPrenatale]);
        }catch (DeleteRestrictionException $deleteRestrictionException){
            $this->revealError('deletingError',$deleteRestrictionException->getMessage());
        }

    }

    /**
     * Archieved the specified resource in storage.
     *
     * @param $slug
     * @return \Illuminate\Http\Response
     * @throws \App\Exceptions\PersonnnalException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function archiver($slug)
    {
        $this->validatedSlug($slug,$this->table);

        $resultat = ConsultationPrenatale::with(['consultationObstetrique','parametresObstetrique'])->whereSlug($slug)->first();
        if (is_null($resultat->passed_at)){
            $this->revealNonTransmis();
        }else{
            $resultat->archieved_at = Carbon::now();
            $resultat->save();
            defineAsAuthor("ConsultationPrenatale",$resultat->id,'archive');
            $resultat->updatePrenatalConsultation();

            //Envoi du sms
            $this->sendSmsToUser($resultat->dossier->patient->user);

            return response()->json(['resultat'=>$resultat]);
        }
    }

    /**
     * Passed the specified resource in storage.
     *
     * @param $slug
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function transmettre($slug)
    {
        $this->validatedSlug($slug,$this->table);

        $resultat = ConsultationPrenatale::with(['consultationObstetrique','parametresObstetrique'])->whereSlug($slug)->first();
        $resultat->passed_at = Carbon::now();
        $resultat->save();
        defineAsAuthor("ConsultationPrenatale",$resultat->id,'transmettre');
        $resultat->updatePrenatalConsultation();
        return response()->json(['resultat'=>$resultat]);

    }
}
