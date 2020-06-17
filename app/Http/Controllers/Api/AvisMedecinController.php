<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Traits\PersonnalErrors;
use App\Http\Requests\AvisMedecinRequest;
use App\Models\Avis;
use App\Models\MedecinAvis;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AvisMedecinController extends Controller
{
    use PersonnalErrors;
    protected $table = 'medecin_avis';
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
    public function store(AvisMedecinRequest $request,$slug)
    {
        $this->validatedSlug($slug,$this->table);

        $avis = MedecinAvis::whereSlug($slug)->first();

        $avis->view = $request->view;
        $avis->avis = $request->avis;
        $avis->save();

        return  response()->json(['avis'=>$avis]);
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

        $avis = MedecinAvis::whereSlug($slug)->first();

        return  response()->json(['avis'=>$avis]);
    }

    public function repondre($aviSlug){
        $medecin = Auth::id();

        $this->validatedSlug($aviSlug,'avis');
        $avis = Avis::whereSlug($aviSlug)->first();

        $medecin_avis = MedecinAvis::where('avis_id',$avis->id)->where('medecin_id',$medecin)->first();

        return response()->json(['avis'=>$medecin_avis]);
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

        $avis = MedecinAvis::whereSlug($slug)->first();
        $avis->delete();

        return  response()->json(['avis'=>$avis]);
    }
}
