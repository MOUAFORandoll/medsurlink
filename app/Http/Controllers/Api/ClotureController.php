<?php

namespace App\Http\Controllers\Api;

use App\Models\Cloture;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Affiliation;
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
        if($request->role == "Assistante"){
            $cloture->ama = Carbon::now();
        }elseif($request->role == "Medecin controle"){
            $cloture->medecin_referent = Carbon::now();
        }elseif($request->role == "Assistante"){
            $cloture->medecin_referent = Carbon::now();
        }
        $cloture->save();
        return response()->json($cloture);
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
