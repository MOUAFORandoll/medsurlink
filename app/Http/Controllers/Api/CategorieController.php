<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Traits\PersonnalErrors;
use App\Http\Requests\CategorieRequest;
use App\Models\Categories;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategorieController extends Controller
{
    use PersonnalErrors;
    protected $table = 'categories';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Categories::all();
        return response()->json(['categories'=>$categories]);
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
    public function store(CategorieRequest $request)
    {
        $categorie = Categories::create($request->all());
        return response()->json(['categorie'=>$categorie]);
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

        $categorie = Categories::with('suivis.responsable.praticien','suivis.dossier.patient.user','suivis.toDoList')->whereSlug($slug)->first();

        return response()->json(['categorie'=>$categorie]);
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
    public function update(CategorieRequest $request, $slug)
    {
        $this->validatedSlug($slug,$this->table);

        Categories::whereSlug($slug)->update($request->all());

        $categorie = Categories::with('suivis.responsable.praticien','suivis.dossier.patient.user','suivis.toDoList')->whereSlug($slug)->first();

        return response()->json(['categorie'=>$categorie]);
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

        $categorie = Categories::whereSlug($slug)->first();

        if ($categorie!=null){
            $categorie->delete();
        }

        return response()->json(['categorie'=>$categorie]);
    }
}
