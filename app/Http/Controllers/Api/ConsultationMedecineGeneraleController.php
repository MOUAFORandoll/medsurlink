<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ConsutationMedecineRequest;
use App\Models\ConsultationMedecineGenerale;
use App\Models\Motif;
use Carbon\Carbon;
use Netpok\Database\Support\DeleteRestrictionException;

class ConsultationMedecineGeneraleController extends Controller
{
    protected $table = 'consultation_medecine_generales';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $consultations = ConsultationMedecineGenerale::with(['dossier','motifs','traitements','conclusions'])->get();
        foreach ($consultations as $consultation){
            $user = $consultation->dossier->patient->user;
            $patient = $consultation->dossier->patient;
            $consultation['user']=$user;
            $consultation['patient']=$patient;
            $isAuthor = checkIfIsAuthorOrIsAuthorized("ConsultationMedecineGenerale",$consultation->id,"create");
            $consultation['isAuthor']=$isAuthor->getOriginalContent();
        }
        return response()->json(["consultations"=>$consultations]);
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
    public function store(ConsutationMedecineRequest $request)
    {


        $consultation = ConsultationMedecineGenerale::create($request->validated());
        $motifs = $request->get('motifs');
        $motifACreer = $request->get('motifsACreer');
//         motif
        if (!is_null($motifACreer) or !empty($motifACreer)){
            foreach ( $motifACreer as $motif)
            {
                $motif = Motif::create([
                    'reference'=>$motif
                ]);
                $consultation->motifs()->attach($motif->id);
            }
        }

        if (!is_null($motifs) or !empty($motifs)){
            foreach ( $motifs as $motif)
            {
                $consultation->motifs()->attach($motif);
            }
        }
        $consultation->date_consultation = dateOfToday();
        $consultation->save();
        defineAsAuthor("ConsultationMedecineGenerale",$consultation->id,'create');

        $consultation = ConsultationMedecineGenerale::with(['dossier','motifs','traitements','conclusions'])->find($consultation->id);
        $user = $consultation->dossier->patient->user;
        $patient = $consultation->dossier->patient;
        $consultation['user']=$user;
        $consultation['patient']=$patient;

        return response()->json(["consultation"=>$consultation]);
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

        $consultation = ConsultationMedecineGenerale::with(['dossier','motifs','traitements','conclusions'])->whereSlug($slug)->first();
        $user = $consultation->dossier->patient->user;
        $patient = $consultation->dossier->patient;
        $consultation['user']=$user;
        $consultation['patient']=$patient;
        $isAuthor = checkIfIsAuthorOrIsAuthorized("ConsultationMedecineGenerale",$consultation->id,"create");
        $consultation['isAuthor']=$isAuthor->getOriginalContent();
        return response()->json(["consultation"=>$consultation]);

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
    public function update(ConsutationMedecineRequest $request, $slug)
    {

        $validation = validatedSlug($slug,$this->table);
        if(!is_null($validation))
            return $validation;

        $consultation = ConsultationMedecineGenerale::findBySlug($slug);
        $isAuthor = checkIfIsAuthorOrIsAuthorized("ConsultationMedecineGenerale",$consultation->id,"create");
        if($isAuthor->getOriginalContent() == false){
            return response()->json(['error'=>"Vous ne pouvez modifié un élement que vous n'avez crée"],401);
        }

        ConsultationMedecineGenerale::whereSlug($slug)->update($request->validated());

        $consultation = ConsultationMedecineGenerale::with(['dossier','motifs','traitements','conclusions'])->whereSlug($slug)->first();
        $user = $consultation->dossier->patient->user;
        $patient = $consultation->dossier->patient;
        $consultation['user']=$user;
        $consultation['patient']=$patient;
        $consultation['isAuthor']=$isAuthor->getOriginalContent();
        return response()->json(["consultation"=>$consultation]);
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

        $consultation = ConsultationMedecineGenerale::with(['dossier','motifs','traitements','conclusions'])->whereSlug($slug)->first();
        $isAuthor = checkIfIsAuthorOrIsAuthorized("ConsutationMedecine",$consultation->id,"create");
        if($isAuthor->getOriginalContent() == false){
            return response()->json(['error'=>"Vous ne pouvez modifié un élement que vous n'avez crée"],401);
        }
        try{
            $consultation = ConsultationMedecineGenerale::findBySlug($slug);
            $consultation->delete();
            return response()->json(["consultation"=>$consultation]);
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

        $resultat = ConsultationMedecineGenerale::with(['dossier','motifs','traitements','conclusions'])->whereSlug($slug)->first();
        if (is_null($resultat->passed_at)){
            $transmission = [];
            $transmission['nonTransmis'] = "Ce resultat n'a pas encoré été transmis";
            return response()->json(['error'=>$transmission],419 );
        }else{
            $resultat->archieved_at = Carbon::now();
            $resultat->save();
            $isAuthor = checkIfIsAuthorOrIsAuthorized("ConsultationMedecineGenerale",$resultat->id,"create");
            $consultation['isAuthor']=$isAuthor->getOriginalContent();
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

        $resultat = ConsultationMedecineGenerale::with(['dossier','motifs','traitements','conclusions'])->whereSlug($slug)->first();
        $resultat->passed_at = Carbon::now();
        $resultat->save();
        $isAuthor = checkIfIsAuthorOrIsAuthorized("ConsultationMedecineGenerale",$resultat->id,"create");
        $consultation['isAuthor']=$isAuthor->getOriginalContent();
        return response()->json(['resultat'=>$resultat]);

    }

}
