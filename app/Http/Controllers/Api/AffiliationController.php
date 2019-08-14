<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\AffiliationRequest;
use App\Models\Affiliation;
use App\Models\Patient;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AffiliationController extends Controller
{
    protected $table = 'affiliations';



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $affiliations = Affiliation::with(['patient'])->get();
        return response()->json(['affiliations'=>$affiliations]);
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
    public function store(AffiliationRequest $request)
    {
        if ($request->has('error'))
        {
            return  response()->json(['error'=>$request->all()['error']],419);
        }

        $message = $this->dejaAffilie($request);
        if (strlen($message)>0){
            return response()->json(['erreur'=>$message],419);
        }
        else{
            $affiliation = Affiliation::create($request->validated());
            $affiliation->date_fin = $this->evaluerDateFin($affiliation);
            $affiliation->save();
            defineAsAuthor("Affiliation",$affiliation->id,'create');
            return response()->json(['affiliation'=>$affiliation]);
        }
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

        $affiliation = Affiliation::with(['patient'])->whereSlug($slug)->first();
        return response()->json(['affiliation'=>$affiliation]);
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
    public function update(AffiliationRequest $request, $slug)
    {
        $validation = validatedSlug($slug,$this->table);
        if(!is_null($validation))
            return $validation;

        $message = $this->dejaAffilie($request);
        if (strlen($message)>0){
            return response()->json(['erreur'=>$message],419);
        }
        else {
            Affiliation::whereSlug($slug)->update($request->validated());

            $affiliation = Affiliation::with(['patient'])->whereSlug($slug)->first();
            $affiliation->date_fin = $this->evaluerDateFin($affiliation);
            $affiliation->save();

            return response()->json(['affiliation' => $affiliation]);
        }
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

        $affiliation = Affiliation::with(['patient'])->whereSlug($slug)->first();
        $affiliation->delete();
        return response()->json(['affiliation'=>$affiliation]);
    }

    public function evaluerDateFin(Affiliation $affiliation){
        $date_debut = $affiliation->date_debut;
        if ($affiliation->nom == 'One shot'){
            $date_fin = $date_debut;
        }elseif ($affiliation->nom == 'Annuelle'){
            $date_fin = Carbon::parse($date_debut)->addYears(1)->format('Y-m-d');
        }
        return $date_fin;
    }

    public function dejaAffilie(Request $request){
        $date_debut = Carbon::parse($request->date_debut)->year;
        //Ici on determine si le patient a deja une affiliation pour cette année
        $affiliation =  Affiliation::where('patient_id','=',$request->patient_id)->where('nom','=','Annuelle')->WhereYear('date_debut',$date_debut)->get();
        if (count($affiliation)>0) {
            return "Le patient dispose déjà d'une affiliation pour cette année";
        }
        elseif ($request->nom == "One shot"){
//            On determine si le patient a deja une affiliation oneshot a ce jour
            $date_debut = $request->date_debut;
            if (is_null($request->date_fin)){
                $date_fin = Carbon::now()->format('Y-m-d');
            }else{
                $date_fin = $request->date_fin;
                if ($date_fin != $date_debut){
                    return "L'affiliation One shot se fait en un seul jour";
                }
            }
            if ($date_fin == $date_debut){
                $affiliation =  Affiliation::where('patient_id','=',$request->patient_id)->where('nom','=','One shot')->whereDate('date_debut',$date_debut)->whereDate('date_fin',$date_fin)->get();
                if (count($affiliation)>0){
                    return "Le patient dispose déjà d'une affiliation pour ce jour";
                }
            }
        }

        return "";

    }
}
