<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\PersonnalErrors;
use App\Http\Requests\AffiliationRequest;
use App\Models\Affiliation;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AffiliationController extends Controller
{
    use PersonnalErrors;
    protected $table = 'affiliations';



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $affiliations = Affiliation::with(['patient'])->get();
        foreach ($affiliations as $affiliation){
            if (!is_null($affiliation->patient)){
                $affiliation['user'] = $affiliation->patient->user;
                $affiliation['souscripteur'] = $affiliation->patient->souscripteur->user;
            }
        }
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
     * @param AffiliationRequest $request
     * @return \Illuminate\Http\Response
     * @throws \App\Exceptions\PersonnnalException
     */
    public function store(AffiliationRequest $request)
    {

        $this->Affiliated($request);

        $affiliation = Affiliation::create($request->validated());

        $this->updateDateFin($affiliation);

        defineAsAuthor("Affiliation",$affiliation->id,'create',$request->patient_id);

        return response()->json(['affiliation'=>$affiliation]);

    }


    /**
     * @param $slug
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function show($slug)
    {
        $this->validatedSlug($slug,$this->table);
        $affiliation = Affiliation::with(['patient'])->whereSlug($slug)->first();
        if (!is_null($affiliation->patient)) {
            $affiliation['user'] = $affiliation->patient->user;
            $affiliation['souscripteur'] = $affiliation->patient->souscripteur->user;
        }
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
     * @param AffiliationRequest $request
     * @param $slug
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\PersonnnalException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(AffiliationRequest $request, $slug)
    {

        $this->validatedSlug($slug,$this->table);

        $this->Affiliated($request);

        Affiliation::whereSlug($slug)->update($request->validated());

        $affiliation = Affiliation::with(['patient'])->whereSlug($slug)->first();

        $this->updateDateFin($affiliation);

        return response()->json(['affiliation' => $affiliation]);

    }


    /**
     * @param $slug
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function destroy($slug)
    {
        $this->validatedSlug($slug,$this->table);

        $affiliation = Affiliation::with(['patient'])->whereSlug($slug)->first();
        $affiliation->delete();

        return response()->json(['affiliation'=>$affiliation]);
    }

    /**
     * @param Affiliation $affiliation
     */
    public function updateDateFin(Affiliation $affiliation){
        $date_debut = $affiliation->date_debut;

        if ($affiliation->nom == 'One shot'){
            $date_fin = $date_debut;

        }elseif ($affiliation->nom == 'Annuelle'){
            $date_fin = Carbon::parse($date_debut)->addYears(1)->format('Y-m-d');
        }

        $affiliation->date_fin = $date_fin;
        $affiliation->save();
    }

    /**
     * Permet de determiner si un utilisateur possede deja une affiliation
     * @param Request $request
     * @throws \App\Exceptions\PersonnnalException
     */
    public function Affiliated(Request $request){
        $date_debut = Carbon::parse($request->date_debut)->year;

        //Ici on determine si le patient a deja une affiliation pour cette année
        $affiliation =  Affiliation::where('patient_id','=',$request->patient_id)->where('nom','=','Annuelle')->WhereYear('date_debut',$date_debut)->get();

        if (count($affiliation)>0) {
            $message = "Le patient dispose déjà d'une affiliation pour cette année";
            $this->revealError('dejaAffilie',$message);

        } elseif ($request->nom == "One shot"){
            //On determine si le patient a deja une affiliation oneshot a ce jour
            $date_debut = $request->date_debut;

            if (is_null($request->date_fin)){
                $date_fin = Carbon::now()->format('Y-m-d');

            }else{
                $date_fin = $request->date_fin;

                if ($date_fin != $date_debut){
                    $message = "L'affiliation One shot se fait en un seul jour";
                    $this->revealError('dejaAffilie',$message);
                }
            }

            if ($date_fin == $date_debut){
                $affiliation =  Affiliation::where('patient_id','=',$request->patient_id)->where('nom','=','One shot')->whereDate('date_debut',$date_debut)->whereDate('date_fin',$date_fin)->get();
                if (count($affiliation)>0){
                    $message = "Le patient dispose déjà d'une affiliation pour ce jour";
                    $this->revealError('dejaAffilie',$message);
                }
            }
        }
    }
}
