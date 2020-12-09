<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Traits\PersonnalErrors;
use App\Http\Requests\PartenaireRequest;
use App\Models\Partenaire;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PartenaireController extends Controller
{
    protected $table = 'partenaires';
    use PersonnalErrors;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $partenaires = Partenaire::all();

        return  response()->json(['partenaires'=>$partenaires]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PartenaireRequest $request)
    {
        $partenaire = Partenaire::create($request->validated());

        return  response()->json(['partenaire'=>$partenaire]);
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $this->validatedSlug($slug,$this->table);

        $partenaire = Partenaire::whereSlug($slug)->first();

        return  response()->json(['partenaire'=>$partenaire]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function update(PartenaireRequest $request, $slug)
    {
        $this->validatedSlug($slug,$this->table);

        Partenaire::whereSlug($slug)->update($request->validated());

        $partenaire = Partenaire::whereSlug($slug)->first();

        return  response()->json(['partenaire'=>$partenaire]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        $partenaire = Partenaire::whereSlug($slug)->first();

        $partenaire->delete();

        return  response()->json(['partenaire'=>$partenaire]);
    }
}
