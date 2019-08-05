<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\ConsutationMedecineRequest;
use App\Models\ConsultationMedecineGenerale;
use App\Models\ExamenClinique;
use App\Models\ExamenComplementaire;
use App\Models\Motif;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
        $consultations = ConsultationMedecineGenerale::with(['motifs','examensClinique','examensComplementaire','allergies','traitements'])->get();
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
        $examensClinique = $request->get('examensClinique');
        $examensCliniqueACreer = $request->get('examensCliniqueACreer');
        $examensCom = $request->get('examensCom');
        $examensComACreer = $request->get('examensComACreer');

//  examen clinique
        if (!is_null($examensCliniqueACreer) or !empty($examensCliniqueACreer)){
            foreach ( $examensCliniqueACreer as $examen)
            {
                $examen = ExamenClinique::create([
                    'reference'=>$examen
                ]);
                $consultation->examensClinique()->attach($examen->id);
            }
        }

        if (!is_null($examensClinique) or !empty($examensClinique)){
                $consultation->examensClinique()->attach($examen);
        }

//          examen complementaire
        if (!is_null($examensComACreer) or !empty($examensComACreer)){
            foreach ( $examensComACreer as $examen)
            {
                $examen = ExamenComplementaire::create([
                    'reference'=>$examen
                ]);
                $consultation->examensComplementaire()->attach($examen->id);
            }
        }

        if (!is_null($examensCom) or !empty($examensCom)){
                $consultation->examensComplementaire()->attach($examen);
        }


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

        $consultation = ConsultationMedecineGenerale::with(['motifs','examensClinique','examensComplementaire','allergies','traitements'])->find($consultation->id);
        return response()->json(["consultation"=>$consultation]);
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

        $consultation = ConsultationMedecineGenerale::with(['motifs'])->find($id);
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
    public function update(ConsutationMedecineRequest $request, $id)
    {
        $validation = validatedId($id,$this->table);
        if(!is_null($validation))
            return $validation;

        $isAuthor = checkIfIsAuthorOrIsAuthorized("ConsultationMedecineGenerale",$id,"create");
        if($isAuthor->getOriginalContent() == false){
            return response()->json(['error'=>"Vous ne pouvez modifié un élement que vous n'avez crée"],401);
        }

        ConsultationMedecineGenerale::whereId($id)->update($request->validated());

        $consultation = ConsultationMedecineGenerale::with(['motifs','examensClinique','examensComplementaire','allergies','traitements'])->find($id);
        return response()->json(["consultation"=>$consultation]);
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

        $isAuthor = checkIfIsAuthorOrIsAuthorized("ConsutationMedecine",$id,"create");
        if($isAuthor->getOriginalContent() == false){
            return response()->json(['error'=>"Vous ne pouvez modifié un élement que vous n'avez crée"],401);
        }

        $consultation = ConsultationMedecineGenerale::find($id);
        ConsultationMedecineGenerale::destroy($id);
        return response()->json(["consultation"=>$consultation]);
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
        $validation = validatedId($id,$this->table);
        if(!is_null($validation))
            return $validation;

        $resultat = ConsultationMedecineGenerale::with(['dossier','consultation'])->find($id);
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
        $validation = validatedId($id,$this->table);
        if(!is_null($validation))
            return $validation;

        $resultat = ConsultationMedecineGenerale::with(['dossier','consultation'])->find($id);
        $resultat->passed_at = Carbon::now();
        $resultat->save();

        return response()->json(['resultat'=>$resultat]);

    }

}
