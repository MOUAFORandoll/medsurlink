<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Traits\PersonnalErrors;
use App\Http\Requests\TraitementActuelRequest;
use App\Http\Requests\TraitementActuelUpdateRequest;
use App\Models\DossierMedical;
use App\Models\TraitementActuel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TraitementActuelController extends Controller
{
    use PersonnalErrors;
    protected $table = "traitement_actuels";

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $traitements = TraitementActuel::with('dossier')->get();

        return response()->json([
            'traitements' => $traitements
        ]);
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
     * @param TraitementActuelRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(TraitementActuelRequest $request)
    {
        $traitements = $request->get('traitements');

        foreach ($traitements as $traitement){

            $traitementCreer =   TraitementActuel::create([
                'dossier_medical_id'=>$request->get('dossier_medical_id'),
                'description'=>$traitement['description']
            ]);

            defineAsAuthor("TraitementActuel", $traitementCreer->id,'create');

        }
        $dossier = DossierMedical::with([
            'allergies'=> function ($query) {
                $query->orderBy('date', 'desc');
            },
            'patient',
            'consultationsMedecine',
            'consultationsObstetrique',
            'traitements'=> function ($query) {
                $query->orderBy('created_at', 'desc');
            }
        ])->whereId($request->get('dossier_medical_id'))->first();
        foreach ($dossier->traitements as $traitement){
            $traitement->updateTraitementActuel();
        }
        return response()->json([
            'dossier' => $dossier
        ]);
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
        $this->validatedSlug($slug, $this->table);

        $traitement = TraitementActuel::with('dossier')
            ->whereSlug($slug)
            ->first();

        $traitement->updateTraitementActuel();

        return response()->json([
            'traitement' => $traitement
        ]);
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
     * @param TraitementActuelUpdateRequest $request
     * @param $slug
     * @return \Illuminate\Http\Response
     * @throws \App\Exceptions\PersonnnalException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(TraitementActuelUpdateRequest $request, $slug)
    {
        $this->validatedSlug($slug,$this->table);

        $traitement = TraitementActuel::findBySlug($slug);

        $this->checkIfAuthorized("TraitementActuel", $traitement->id,"create");

        TraitementActuel::whereSlug($slug)->update($request->validated());

        $traitement = TraitementActuel::with('dossier')->whereSlug($slug)->first();

        return response()->json([
            'traitement' => $traitement
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $slug
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function destroy($slug)
    {
        $this->validatedSlug($slug, $this->table);

        $traitement = TraitementActuel::with('dossier')->whereSlug($slug)->first();
        $traitement->delete();

        $dossier = DossierMedical::with([
            'allergies'=> function ($query) {
                $query->orderBy('date', 'desc');
            },
            'patient',
            'consultationsMedecine',
            'consultationsObstetrique',
            'traitements'=> function ($query) {
                $query->orderBy('created_at', 'desc');
            }
        ])->whereId($traitement->dossier->id)->first();
        foreach ($dossier->traitements as $traitement){
            $traitement->updateTraitementActuel();
        }
        return response()->json([
            'dossier' => $dossier
        ]);
    }
}
