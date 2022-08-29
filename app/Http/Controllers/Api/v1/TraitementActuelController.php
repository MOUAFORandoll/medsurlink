<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Traits\PersonnalErrors;
use App\Http\Requests\TraitementActuelRequest;
use App\Http\Requests\TraitementActuelUpdateRequest;
use App\Models\DossierMedical;
use App\Models\TraitementActuel;
use App\Traits\DossierTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TraitementActuelController extends Controller
{
    use PersonnalErrors;
    use DossierTrait;

    protected $table = "traitement_actuels";

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $dossier_medical_slug = $request->dossier_slug;
        $traitements = TraitementActuel::whereHas('dossier', function($query) use($dossier_medical_slug) {
            $query->where('slug', $dossier_medical_slug);
        })->latest()->get();

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
    public function store(Request $request)
    {
        $this->validate($request, [
            "dossier_slug"=>"required|exists:dossier_medicals,slug",
            "description"=>"required|string|min:3",
        ]);

        $dossier = DossierMedical::whereSlug($request->dossier_slug)->first();


        $traitement =   TraitementActuel::create([
            'dossier_medical_id' => $dossier->id,
            'description' => $request->get('description')
        ]);

        defineAsAuthor("TraitementActuel", $traitement->id,'create',$traitement->dossier->patient->user_id);


        return response()->json(['traitement' => $traitement]);
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

        $traitement = TraitementActuel::whereSlug($slug)->first();

        return response()->json(['traitement' => $traitement]);
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
    public function update(Request $request, $slug)
    {
        $this->validatedSlug($slug,$this->table);
        $this->validate($request, [
            "dossier_slug"=>"required|exists:dossier_medicals,slug",
            "description"=>"required|string|min:3",
        ]);

        $dossier = DossierMedical::whereSlug($request->dossier_slug)->first();


        $traitement = TraitementActuel::findBySlug($slug);

        $this->checkIfAuthorized("TraitementActuel", $traitement->id,"create");

        TraitementActuel::whereSlug($slug)->update([ 'dossier_medical_id' => $dossier->id, 'description' => $request->get('description')]);

        $traitement = $traitement->fresh();

        return response()->json([ 'traitement' => $traitement]);
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

        $traitement = TraitementActuel::whereSlug($slug)->first();
        $traitement->delete();

        return response()->json(['traitement' => $slug]);
    }
}
