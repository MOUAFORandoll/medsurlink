<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\PersonnalErrors;
use App\Http\Requests\CategoriePrestationRequest;
use App\Models\CategoriePrestation;
use App\Models\Categories;
use Illuminate\Http\Request;

class CategoriePrestationController extends Controller
{
    use PersonnalErrors;
    protected $table = 'categorie_prestations';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = CategoriePrestation::with('prestations')->get();

        return  response()->json(['categories'=>$categories]);

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
    public function store(CategoriePrestationRequest $request)
    {
        $categorie = CategoriePrestation::create($request->all());
        return  response()->json(['categorie'=>$categorie]);
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
        $categorie = CategoriePrestation::with('prestations')->whereSlug($slug)->first();
        return  response()->json(['categorie'=>$categorie]);
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
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function update(CategoriePrestationRequest $request, $slug)
    {
        $this->validatedSlug($slug,$this->table);
        CategoriePrestation::whereSlug($slug)->update($request->validated());
        $categorie = CategoriePrestation::with('prestations')->whereSlug($slug)->first();
        return  response()->json(['categorie'=>$categorie]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        $this->validatedSlug($slug,$this->table);

        $categorie = CategoriePrestation::with('prestations')->whereSlug($slug)->first();

        $categorie->delete();

        return  response()->json(['categorie'=>$categorie]);
    }
}
