<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\TraitementProposeRequest;
use App\Models\TraitementPropose;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TraitementProposeController extends Controller
{
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
     */
    public function show($slug)
    {
        $validation = validatedSlug($slug, $this->table);

        if(!is_null($validation))
            return $validation;

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
     */
    public function update(TraitementProposeRequest $request, $slug)
    {
        $validation = validatedSlug($slug,$this->table);

        if (!is_null($validation))
            return $validation;

        $traitement = TraitementPropose::findBySlug($slug);

        $isAuthor = checkIfIsAuthorOrIsAuthorized("TraitementPropose", $traitement->id,"create");

        if (!$isAuthor->getOriginalContent()) {
            $transmission = [];
            $transmission['accessRefuse'][0] = "Vous ne pouvez pas modifier un élément que vous n'avez pas créé";

            return response()->json(
                [
                    'error' => $transmission
                ],
                419
            );
        }

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
     */
    public function destroy($slug)
    {
        $validation = validatedSlug($slug, $this->table);

        if(!is_null($validation))
            return $validation;

        $traitement = TraitementPropose::findBySlug($slug);
        $traitement->delete();

        return response()->json([
            'traitement' => $traitement
        ]);
    }
}
