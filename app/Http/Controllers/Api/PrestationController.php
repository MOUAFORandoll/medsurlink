<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Traits\PersonnalErrors;
use App\Http\Requests\PrestationRequest;
use App\Models\CategoriePrestation;
use App\Models\Prestation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PrestationController extends Controller
{
    use PersonnalErrors;
    protected $table='prestations';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $prestations = Prestation::with('categorie')->get();

        return  response()->json(['prestations'=>$prestations]);
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
    public function store(PrestationRequest $request)
    {
        $categorie_id = $request->get('categorie_id');

        $newCategorie = $request->get('new_categorie');
        if (!is_null($newCategorie)){
            $categorie = CategoriePrestation::whereNom($newCategorie)->first();
            if (is_null($categorie)){
                $categorie = CategoriePrestation::create(['nom'=>$request->get('new_categorie')]);
            }

            $categorie_id = $categorie->id;
        }

        $prestation = Prestation::create($request->except('new_categorie','categorie_id') +
            ['categorie_id'=>$categorie_id]);

        return  response()->json(['prestation'=>$prestation]);
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

        $prestation = Prestation::with('categorie')->whereSlug($slug)->first();

        return  response()->json(['prestation'=>$prestation]);
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
    public function update(PrestationRequest $request, $slug)
    {
        $this->validatedSlug($slug,$this->table);

        $categorie_id = $request->get('categorie_id');

        $newCategorie = $request->get('new_categorie');
        if (!is_null($newCategorie)){
            $categorie = CategoriePrestation::whereNom($newCategorie)->first();
            if (is_null($categorie)){
                $categorie = CategoriePrestation::create(['nom'=>$request->get('new_categorie')]);
            }

            $categorie_id = $categorie->id;
        }

        Prestation::whereSlug($slug)->update($request->except('new_categorie','categorie_id','prestation')+
            ['categorie_id'=>$categorie_id]);

        $prestation = Prestation::whereSlug($slug)->first();

        return  response()->json(['prestation'=>$prestation]);

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

        $prestation = Prestation::whereSlug($slug)->first();

        $prestation->delete();

        return  response()->json(['prestation'=>$prestation]);


    }
}
