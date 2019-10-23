<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\PersonnalErrors;
use App\Http\Requests\ConclusionRequest;
use App\Models\Conclusion;

class ConclusionController extends Controller
{
    use PersonnalErrors;
    protected $table = "conclusions";

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $conclusions = Conclusion::with(['consultationMedecine'])->get();

        foreach ($conclusions as $conclusion){
            $conclusion->updateConclusionItem();
        }

        return response()->json(['conclusions'=>$conclusions]);
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
    public function store(ConclusionRequest $request)
    {

        $conclusion = Conclusion::create($request->validated());

        defineAsAuthor("Conclusion",$conclusion->id,'create');

        $conclusion = Conclusion::with(['consultationMedecine'])->whereSlug($conclusion->slug)->first();

        $conclusion->updateConclusionItem();

        return response()->json(['conclusion'=>$conclusion]);

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

        $conclusion = Conclusion::with(['consultationMedecine'])->whereSlug($slug)->first();

        $conclusion->updateConclusionItem();

        return response()->json(['conclusion'=>$conclusion]);

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
     * @param ConclusionRequest $request
     * @param $slug
     * @return \Illuminate\Http\Response
     * @throws \App\Exceptions\PersonnnalException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(ConclusionRequest $request, $slug)
    {

        $this->validatedSlug($slug,$this->table);

        $conclusion = Conclusion::findBySlug($slug);

        $this->checkIfAuthorized("ConsutationMedecine",$conclusion->id,"create");

        Conclusion::whereSlug($slug)->update($request->validated());

        $conclusion = Conclusion::with(['consultationMedecine'])->whereSlug($slug)->first();

        return response()->json(['conclusion'=>$conclusion]);
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

        $conclusion = Conclusion::with(['consultationMedecine'])->whereSlug($slug)->first();
        $conclusion->delete();

        return response()->json(['conclusion'=>$conclusion]);
    }
}
