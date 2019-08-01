<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\AffiliationRequest;
use App\Models\Affiliation;
use App\Models\Patient;
use Carbon\Carbon;
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
    public function show($id)
    {
        $validation = validatedId($id,$this->table);
        if(!is_null($validation))
            return $validation;

        $affiliation = Affiliation::with(['patient'])->find($id);
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
    public function update(AffiliationRequest $request, $id)
    {
        $validation = validatedId($id,$this->table);
        if(!is_null($validation))
            return $validation;

        $message = $this->dejaAffilie($request);
        if (strlen($message)>0){
            return response()->json(['erreur'=>$message],419);
        }
        else {
            Affiliation::whereId($id)->update($request->validated());

            $affiliation = Affiliation::with(['patient'])->find($id);
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
    public function destroy($id)
    {
        $validation = validatedId($id,$this->table);
        if(!is_null($validation))
            return $validation;

        $affiliation = Affiliation::with(['patient'])->find($id);
        Affiliation::destroy($id);
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
        $affiliation =  Affiliation::where('patient_id','=',$request->patient_id)->where('nom','=','Annuelle')->WhereYear('date_debut',$date_debut)->get();
        if (count($affiliation)>0) {
            return "Le patient dispose déjà d'une affiliation pour cette année";
        }
        elseif ($request->nom == "One shot"){
            $date_debut = $request->date_debut;
            $affiliation =  Affiliation::where('patient_id','=',$request->patient_id)->where('nom','=','One shot')->whereDate('date_debut',$date_debut)->get();
            if (count($affiliation)>0){
                return "Le patient dispose déjà d'une affiliation pour ce jour";
            }
        }

        return "";

    }
}
