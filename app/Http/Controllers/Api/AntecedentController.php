<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Traits\PersonnalErrors;
use App\Http\Requests\AntecedentRequest;
use App\Models\Antecedent;
use App\Models\DossierMedical;
use App\Traits\DossierTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AntecedentController extends Controller
{
    use PersonnalErrors;
    use DossierTrait;
    protected $table = "antecedents";

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $antecedents = Antecedent::with('dossier')->get();
        foreach ($antecedents as $antecedent){
            $antecedent->updateAntecedentItem();
        }
        return response()->json(['antecedents'=>$antecedents]);
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
    public function store(AntecedentRequest $request)
    {

        $antecedent = Antecedent::create($request->validated());

        $antecedent = Antecedent::with('dossier')->whereSlug($antecedent->slug)->first();

        defineAsAuthor("Antecedent",$antecedent->id,'create',$antecedent->dossier->patient->user_id);

        $dossier = DossierMedical::with([
            'allergies'=> function ($query) {
                $query->orderBy('date', 'desc');
            },
            'antecedents',
            'patient',
            'consultationsMedecine',
            'consultationsObstetrique',
            'traitements'=> function ($query) {
                $query->orderBy('created_at', 'desc');
            }
        ])->whereId($antecedent->dossier_medical_id)->first();
        $this->updateDossierId($dossier->id);
        $dossier->updateDossier();


        return response()->json(['dossier'=>$dossier]);
//        return response()->json(['antecedent'=>$antecedent]);
    }


    /**
     * @param $slug
     * @return \Illuminate\Http\JsonResponse|null
     * @throws \Illuminate\Validation\ValidationException
     */
    public function show($slug)
    {
        $this->validatedSlug($slug,$this->table);

        $antecedent = Antecedent::with('dossier')->whereSlug($slug)->first();

        $antecedent->updateAntecedentItem();

        return response()->json(['antecedent'=>$antecedent]);

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
     * @param AntecedentRequest $request
     * @param $slug
     * @return \Illuminate\Http\JsonResponse|null
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(AntecedentRequest $request, $slug)
    {

        $this->validatedSlug($slug,$this->table);

        $antecedent = Antecedent::whereSlug($slug)->first();

        $this->checkIfAuthorized("Antecedent",$antecedent->id,"create");

        Antecedent::whereSlug($slug)->update($request->validated());

        $antecedent = Antecedent::with('dossier')->whereSlug($slug)->first();

        $this->updateDossierId($antecedent->dossier->id);

        return response()->json(['antecedent'=>$antecedent]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        $this->validatedSlug($slug,$this->table);

        $antecedent = Antecedent::whereSlug($slug)->first();

        $this->checkIfAuthorized("Antecedent",$antecedent->id,"create");

        $antecedent = Antecedent::with('dossier')->whereSlug($slug)->first();
        $antecedent->delete();

        $dossier = DossierMedical::with([
            'allergies'=> function ($query) {
                $query->orderBy('date', 'desc');
            },
            'antecedents',
            'patient',
            'consultationsMedecine',
            'consultationsObstetrique',
            'traitements'=> function ($query) {
                $query->orderBy('created_at', 'desc');
            }
        ])->whereId($antecedent->dossier_medical_id)->first();

        $this->updateDossierId($dossier->id);

        $dossier->updateDossier();

        return response()->json(['dossier'=>$dossier]);

//        return response()->json(['antecedent'=>$antecedent]);
    }
}
