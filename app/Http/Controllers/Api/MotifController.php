<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Traits\PersonnalErrors;
use App\Http\Requests\MotifRequest;
use App\Models\Motif;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MotifController extends Controller
{
    use PersonnalErrors;
    protected $table = "motifs";
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $motifs = Motif::latest()->get();

        foreach ($motifs as $motif){
            $motif->updateMotif();
        }

        return response()->json(['motifs'=>$motifs]);
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

        $motif = Motif::create($request->validated());

        defineAsAuthor("Motif",$motif->id,'create');

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

        $motif = Motif::findBySlug($slug);

        $motif->updateMotif();

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

        $motif = Motif::findBySlug($slug);

        $this->checkIfAuthorized("Motif",$motif->id,"create");

        Motif::whereSlug($slug)->update($request->validated());

        $motif = Motif::findBySlug($slug);

        return response()->json(['motif'=>$motif]);
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

        $motif  = Motif::findBySlug($slug);

        $this->checkIfAuthorized("Motif",$motif->id,"create");

        $motif = Motif::findBySlug($slug);
        $motif->delete();

        return response()->json(['motif'=>$motif]);
    }


    public function search($motif){
        $motifs = Motif::where('description', 'like', "%{$motif}%")->get();

        foreach ($motifs as $motif){
            $motif->updateMotif();
        }

        return response()->json(['motifs' => $motifs]);
    }
}
