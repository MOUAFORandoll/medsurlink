<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Traits\PersonnalErrors;
use App\Http\Requests\FactureAvisRequest;
use App\Models\Facture;
use App\Models\FactureAvis;
use App\Models\FactureAvisDetail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FactureAvisController extends Controller
{
    use PersonnalErrors;
    protected $table = 'facture_avis';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dossiers = FactureAvis::with([
            'factureDetail',
            'association',
            'avis',
            'dossier'
        ])->get();
        return response()->json(['factureAvis'=>$dossiers]);
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
    public function store(FactureAvisRequest $request)
    {
        $request->validated();
        $avis = $request->avis;
 
        $facture = FactureAvis::create([
            "avis_id" => $request->avis_id,
            "association_id" => $request->association_id,
            "etablissement_id" => $request->etablissement_id,
            "dossier_medical_id" => $request->dossier_medical_id
        ]);
        foreach($avis as $avi){
            $montant_total = $avi['montant_medicasure'] + $avi['montant_association']+$avi['montant_medecin'];
            //dd($montant_total);
            FactureAvisDetail::create([
                "facture_avis_id" => $facture->id,
                "medecin_avis_id" => $avi['id'],
                "total_montant" => $montant_total,
                "medicasure_montant" => $avi['montant_medicasure'],
                "association_montant" => $avi['montant_association'],
                "medecin_avis_montant" => $avi['montant_medecin']
            ]);
        }
        $facture = FactureAvis::whereId($facture->id)->first();

        return response()->json(['facture'=>$facture]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $this->validatedSlug($slug,$this->table);

        $facture = FactureAvis::with('dossier.patient.user','files','etablissement','factureDetail.medecinAvis','avis','association')
            ->whereSlug($slug)->first();

        return response()->json(['facture'=>$facture]);
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

        $facture = FactureAvis::whereSlug($slug)->first();

        if (!is_null($facture))
        $facture->delete();

        $facture = Facture::with('dossier.patient.user','files','etablissement','prestations.prestation_etablissement.prestation')
            ->whereId($facture->facture_id)->first();

        return response()->json(['facture'=>$facture]);
    }

}
