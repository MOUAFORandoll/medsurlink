<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ExamenEtablissementPrix;

class ExamenEtablissementPrixController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $examen_prix = ExamenEtablissementPrix::with(['examenComplementaire','etablissement'])->get();
        return response()->json(['examen_prix'=>$examen_prix]);
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
    public function store(Request $request)
    {
        //dd($request->get('etablissement_exercices_id'));
        $examen_prix =  ExamenEtablissementPrix::create([
            'etablissement_exercices_id' =>$request->etablissement_exercices_id,
            'examen_complementaire_id' =>$request->examen_complementaire_id,
            // 'other_complementaire_id' =>$request->other_complementaire_id,
            'prix' =>$request->prix,
        ]);

        return  response()->json(['examen_prix'=>$examen_prix]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $examen_prix = ExamenEtablissementPrix::whereId($id)->with(['examenComplementaire','etablissement'])->first();
        return response()->json(['examen_prix'=>$examen_prix]);
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        ExamenEtablissementPrix::whereId($id)->update(['prix'=>$request->get('prix')]);

        $examen_prix = ExamenEtablissementPrix::whereId($id)->first();

        return  response()->json(['examen_prix'=>$examen_prix]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
