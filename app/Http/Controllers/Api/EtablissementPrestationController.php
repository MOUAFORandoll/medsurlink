<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Traits\PersonnalErrors;
use App\Http\Requests\EtablissementPrestationRequest;
use App\Models\CategoriePrestation;
use App\Models\EtablissementPrestation;
use App\Models\Prestation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EtablissementPrestationController extends Controller
{
    use PersonnalErrors;
    protected $table = 'etablissement_prestation';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function store(EtablissementPrestationRequest $request)
    {
        $categorie_id = $request->get('categorie_id');

        // Creation d'une nouvelle categorie
        $newCategorie = $request->get('new_categorie');
        if (!is_null($newCategorie)){
            $categorie = CategoriePrestation::whereNom($newCategorie)->first();
            if (is_null($categorie)){
                $categorie = CategoriePrestation::create(['nom'=>$request->get('new_categorie')]);
            }

            $categorie_id = $categorie->id;
        }
        if($categorie_id == null || $categorie_id == 'null'){
            $categorie_id = null;
        }

        // Creation d'une nouvelle prestation
        $nom = $request->get('nom');
        $prestation_id = $request->get('prestation_id');

        if($prestation_id == null || $prestation_id == 'null'){
            $prestation_id = null;
        }

        if (!is_null($nom)){
            $prestation = Prestation::whereNom($nom)->first();
            if (is_null($prestation)){
                $prestation = Prestation::create(['nom'=>$nom,'categorie_id'=>$categorie_id]);
            }

            $prestation_id = $prestation->id;
        }


        $prestation =  EtablissementPrestation::create([
            'etablissement_id'=>$request->etablissement_id,
            'prestation_id'=>$prestation_id,
            'prix'=>$request->prix,
            'reduction'=>$request->reduction
        ]);

        return  response()->json(['etablissementPrestation'=>$prestation]);
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

        $prestation = EtablissementPrestation::with('etablissement','prestation.categorie')->whereSlug($slug)->first();

        return response()->json(['prestation'=>$prestation]);
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
    public function update(EtablissementPrestationRequest $request, $slug)
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
        if($categorie_id == null || $categorie_id == 'null'){
            $categorie_id = null;
        }
        $prestation = Prestation::whereId($request->prestation_id)->first();

        $prestation->categorie_id = $categorie_id;
        $prestation->nom = $request->nom;
        $prestation->save();

        EtablissementPrestation::whereSlug($slug)->update($request->except('nom','prestation','new_categorie','categorie_id'));

        $prestation = EtablissementPrestation::whereSlug($slug)->first();

        return  response()->json(['etablissementPrestation'=>$prestation]);
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

        $prestation = EtablissementPrestation::whereSlug($slug)->first();

        if (!is_null($prestation))
            $prestation->delete();

        return  response()->json(['prestation'=>$prestation]);
    }
}
