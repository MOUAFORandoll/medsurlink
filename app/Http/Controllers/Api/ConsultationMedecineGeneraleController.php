<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\PersonnalErrors;
use App\Http\Requests\ConsutationMedecineRequest;
use App\Models\Antecedent;
use App\Models\Conclusion;
use App\Models\ConsultationMedecineGenerale;
use App\Models\Motif;
use Carbon\Carbon;
use Netpok\Database\Support\DeleteRestrictionException;

class ConsultationMedecineGeneraleController extends Controller
{
    use PersonnalErrors;
    protected $table = 'consultation_medecine_generales';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $consultations = ConsultationMedecineGenerale::with(['dossier','motifs','traitements','conclusions','parametresCommun'])->orderByDateConsultation()->get();

        foreach ($consultations as $consultation){
            $consultation->updateConsultationMedecine();
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

        return response()->json(compact('allergies','antecedents','motifs','conclusions'),419);
        $consultation = ConsultationMedecineGenerale::create($request->validated());

        $consultation = ConsultationMedecineGenerale::with(['dossier','traitements','conclusions','parametresCommun'])->find($consultation->id);

        defineAsAuthor("ConsultationMedecineGenerale",$consultation->id,'create',$consultation->dossier->patient->user_id);

        $motifs = $request->get('motifs');

        $conclusions = $request->get('conclusions');

        //Insertion des motifs
        foreach ($motifs as $motif){
            if (is_integer($motif)){
                $consultation->motifs()->attach($request->get('motifs'));
                defineAsAuthor("ConsultationMotif", $motif, 'attach',$consultation->dossier->patient->user_id);

            }else{
              $item =   Motif::create([
                    "reference"=>$consultation->date_consultation,
                    "description"=>$motif
                ]);

                defineAsAuthor("Motif", $item->id, 'create');
                $consultation->motifs()->attach($item->id);
                defineAsAuthor("ConsultationMotif", $item->id, 'attach',$consultation->dossier->patient->user_id);

            }
        }

       $conclusion =  Conclusion::create([
            'consultation_medecine_generale_id' =>$consultation->id,
            "description"=>$conclusions
        ]);

        defineAsAuthor("Conclusion",$conclusion->id,'create',$conclusion->consultationMedecine->dossier->patient->user_id);


        if(!is_null($consultation))
            $consultation->updateConsultationMedecine();

        return response()->json(["consultation"=>$consultation]);
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

        $consultation = ConsultationMedecineGenerale::with(['dossier','dossier.allergies','dossier.antecedents','motifs','dossier.traitements','conclusions','parametresCommun'])->whereSlug($slug)->first();

        $consultation->updateConsultationMedecine();

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
     * @param ConsutationMedecineRequest $request
     * @param $slug
     * @return \Illuminate\Http\Response
     * @throws \App\Exceptions\PersonnnalException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(ConsutationMedecineRequest $request, $slug)
    {

        $this->validatedSlug($slug,$this->table);

        $consultation = ConsultationMedecineGenerale::findBySlug($slug);

        $this->checkIfAuthorized("ConsultationMedecineGenerale",$consultation->id,"create");

        ConsultationMedecineGenerale::whereSlug($slug)->update($request->validated());

        $consultation = ConsultationMedecineGenerale::with(['dossier','motifs','traitements','conclusions','parametresCommun'])->whereSlug($slug)->first();

        $consultation->updateConsultationMedecine();

        return response()->json(["consultation"=>$consultation]);
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

        $consultation = ConsultationMedecineGenerale::with(['dossier','motifs','traitements','conclusions','parametresCommun'])->whereSlug($slug)->first();

        $this->checkIfAuthorized("ConsutationMedecine",$consultation->id,"create");

        try{
            $consultation = ConsultationMedecineGenerale::findBySlug($slug);
            $consultation->delete();
            return response()->json(["consultation"=>$consultation]);
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

        $resultat = ConsultationMedecineGenerale::with(['dossier','motifs','traitements','conclusions','parametresCommun'])->whereSlug($slug)->first();

        if (is_null($resultat->passed_at)){
            $this->revealNonTransmis();

        }else{
            $resultat->archieved_at = Carbon::now();
            $resultat->save();

            defineAsAuthor("ConsultationMedecineGenerale",$resultat->id,'archive');
            return response()->json(['resultat'=>$resultat]);
        }
    }

    /**
     * Passed the specified resource in storage.
     *
     * @param $slug
     * @return \Illuminate\Http\Response
     * @throws \App\Exceptions\PersonnnalException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function transmettre($slug)
    {
        $this->validatedSlug($slug,$this->table);

        $resultat = ConsultationMedecineGenerale::with(['dossier','motifs','traitements','conclusions','parametresCommun'])->whereSlug($slug)->first();
        $resultat->passed_at = Carbon::now();
        $resultat->save();

        defineAsAuthor("ConsultationMedecineGenerale",$resultat->id,'transmettre');
        return response()->json(['resultat'=>$resultat]);

    }

}
