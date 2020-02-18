<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\PersonnalErrors;
use App\Http\Requests\AllergieRequest;
use App\Models\Allergie;

class AllergieController extends Controller
{
    use PersonnalErrors;
    protected  $table = "allergies";

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $allergies = Allergie::all();

        foreach ($allergies as $allergy){
            $allergy->updateAllergyItem();
        }

        return response()->json(['allergies'=>$allergies]);
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
     * @param AllergieRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(AllergieRequest $request)
    {
        $allergie = Allergie::create($request->validated());
        $allergie->updateAllergyItem();
        defineAsAuthor("Allergie",$allergie->id,'create');

        return response()->json(['allergie'=>$allergie]);

    }


    /**
     * @param $slug
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function show($slug)
    {
        $this->validatedSlug($slug,$this->table);

        $allergie = Allergie::whereSlug($slug)->first();

        $allergie->updateAllergyItem();

        return response()->json(['allergie'=>$allergie]);

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
     * @param AllergieRequest $request
     * @param $slug
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\PersonnnalException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(AllergieRequest $request, $slug)
    {

        $this->validatedSlug($slug,$this->table);

        $allergie = Allergie::findBySlug($slug);

        $this->checkIfAuthorized("Allergie",$allergie->id,"create");

        Allergie::whereSlug($slug)->update($request->validated());

        $allergie = Allergie::findBySlug($slug);
        $allergie->updateAllergyItem();

        return response()->json(['allergie'=>$allergie]);
    }


    /**
     * @param $slug
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\PersonnnalException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function destroy($slug)
    {
        $this->validatedSlug($slug,$this->table);

        $allergie = Allergie::findBySlug($slug);

        $this->checkIfAuthorized("Allergie",$allergie->id,"create");

        $allergie->delete();

        return response()->json(['allergie'=>$allergie]);
    }
}
