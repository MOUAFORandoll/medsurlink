<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Traits\PersonnalErrors;
use App\Http\Requests\MotifRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Offre;

class OffreController extends Controller
{
    use PersonnalErrors;
    protected $table = "offres";
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $offres = Offre::with(["packages","items","items.packages"])->get();

        //dd($offres);
        return response()->json(['offres'=>$offres]);
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
    public function store(MotifRequest $request)
    {

        $motif = Offre::create($request->validated());

        defineAsAuthor("Offre",$motif->id,'create');

        return response()->json(['motif'=>$motif]);

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

        $motif = Offre::findBySlug($slug);


        return response()->json(['motif'=>$motif]);
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
     * @param MotifRequest $request
     * @param $slug
     * @return \Illuminate\Http\Response
     * @throws \App\Exceptions\PersonnnalException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(MotifRequest $request, $slug)
    {

        $this->validatedSlug($slug,$this->table);

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

    }
}
