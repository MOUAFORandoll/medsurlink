<?php

namespace App\Http\Controllers\Api;

use App\Models\Cloture;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Affiliation;
use App\Models\LigneDeTemps;
use Carbon\Carbon;

class ClotureController extends Controller
{
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
    public function store(Request $request)
    {
        $cloture = Cloture::where(['cloturable_id' => $request->id, 'cloturable_type' => 'Affiliation'])->first();
        $cloture = $this->cloturer($cloture);
        return response()->json($cloture);
    }

    public function ligne(Request $request){
        $cloture = Cloture::where(['cloturable_id' => $request->id, 'cloturable_type' => 'App\Models\LigneDeTemps'])->first();
        $cloture = $this->cloturer($cloture);
        return response()->json($cloture);
    }

    public function cloturer( Cloture $cloture){

        if(auth()->user()->hasrole("Assistante")){
            $cloture->ama = Carbon::now();
        }elseif(auth()->user()->hasrole("Medecin controle")){
            $cloture->medecin_referent = Carbon::now();
        }elseif(auth()->user()->hasrole("Gestionnaire")){
            $cloture->medecin_referent = Carbon::now();
        }

        $cloture->save();

        return $cloture;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Cloture  $cloture
     * @return \Illuminate\Http\Response
     */
    public function show(Cloture $cloture)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Cloture  $cloture
     * @return \Illuminate\Http\Response
     */
    public function edit(Cloture $cloture)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Cloture  $cloture
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cloture $cloture)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Cloture  $cloture
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cloture $cloture)
    {
        //
    }
}
