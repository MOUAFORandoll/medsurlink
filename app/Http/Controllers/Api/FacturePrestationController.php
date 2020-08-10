<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Traits\PersonnalErrors;
use App\Http\Requests\FacturePrestationRequest;
use App\Models\Facture;
use App\Models\FacturePrestation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FacturePrestationController extends Controller
{
    use PersonnalErrors;
    protected $table = 'facture_prestations';
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
    public function store(FacturePrestationRequest $request)
    {
        $facture = FacturePrestation::create($request->validated());

        $facture = Facture::with('dossier.patient.user','files','etablissement','prestations.prestation_etablissement.prestation')
            ->whereId($facture->facture_id)->first();

        return response()->json(['facture'=>$facture]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
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

        $facture = FacturePrestation::whereSlug($slug)->first();

        if (!is_null($facture))
        $facture->delete();

        $facture = Facture::with('dossier.patient.user','files','etablissement','prestations.prestation_etablissement.prestation')
            ->whereId($facture->facture_id)->first();

        return response()->json(['facture'=>$facture]);
    }
}
