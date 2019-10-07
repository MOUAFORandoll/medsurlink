<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Traits\PersonnalErrors;
use App\Http\Requests\TraitementProposeRequest;
use App\Models\TraitementPropose;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TraitementProposeController extends Controller
{
    use PersonnalErrors;
    protected $table = 'traitement_proposes';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $traitements = TraitementPropose::with('consultation')->get();

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
     * @param TraitementProposeRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(TraitementProposeRequest $request)
    {
        $traitement = TraitementPropose::create($request->validated());

        defineAsAuthor("TraitementPropose", $traitement->id,'create');

        return response()->json([
            'traitement' => $traitement
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

        $traitement = TraitementPropose::with('consultation')
            ->whereSlug($slug)
            ->first();

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
     * @param TraitementProposeRequest $request
     * @param $slug
     * @return \Illuminate\Http\Response
     * @throws \App\Exceptions\PersonnnalException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(TraitementProposeRequest $request, $slug)
    {
        $this->validatedSlug($slug,$this->table);

        $traitement = TraitementPropose::findBySlug($slug);

        $this->checkIfAuthorized("TraitementPropose", $traitement->id,"create");

        TraitementPropose::whereSlug($slug)->update($request->validated());
        $traitement = TraitementPropose::findBySlug($slug);

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

        $traitement = TraitementPropose::findBySlug($slug);
        $traitement->delete();

        return response()->json([
            'traitement' => $traitement
        ]);
    }
}
