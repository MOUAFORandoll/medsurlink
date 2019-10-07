<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\PersonnalErrors;
use App\Http\Requests\EtablissementExerciceRequest;
use App\Models\EtablissementExercice;
use Illuminate\Support\Facades\Validator;
use Netpok\Database\Support\DeleteRestrictionException;

/**
 * Class EtablissementExerciceController
 * @package App\Http\Controllers\Api
 */
class EtablissementExerciceController extends Controller
{
    use PersonnalErrors;
    protected $table = "etablissement_exercices";

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $etablissements =  EtablissementExercice::with(['praticiens','patients'])->get();
        return response()->json(['etablissements'=>$etablissements]);
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
    public function store(EtablissementExerciceRequest $request)
    {
        $etablissement = EtablissementExercice::create($request->validated());

        defineAsAuthor("EtablissementExercice",$etablissement->id,'create');

        return response()->json(['etablissement'=>$etablissement]);
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

        $etablissement = EtablissementExercice::with(['praticiens','patients'])->whereSlug($slug)->first();

        return response()->json(['etablissement'=>$etablissement]);


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
     * @param EtablissementExerciceRequest $request
     * @param $slug
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(EtablissementExerciceRequest $request, $slug)
    {
        $this->validatedSlug($slug,$this->table);

        EtablissementExercice::whereSlug($slug)->update($request->validated());

        $etablissement = EtablissementExercice::with(['praticiens','patients'])->whereSlug($slug)->first();

        return response()->json(['etablissement'=>$etablissement]);

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
        $this->validatedSlug($slug,$this->table);

        try{
            $etablissement = EtablissementExercice::with(['praticiens','patients'])->whereSlug($slug)->first();
            $etablissement->delete();
            return response()->json(['etablissement'=>$etablissement]);

        }catch (DeleteRestrictionException $deleteRestrictionException){
            return response()->json(['error'=>$deleteRestrictionException->getMessage()],422);
        }
    }
}
