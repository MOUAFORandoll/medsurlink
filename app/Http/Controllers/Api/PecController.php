<?php

namespace App\Http\Controllers\Api;

use App\Models\Pec;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PecController extends Controller
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
        // $request->validate([
        //     'patient_id'=>'integer|nullable',
        //     'etalissement_id'=>'integer|nullable',
        // ]);
        $request->validate([
            'patient_id'=>'integer|nullable',
            'etablissement_id'=>'integer|nullable'
        ]);
        $pec = new Pec;
        $pec->creator = Auth::id();
        $pec->patient_id = $request->patient_id;
        $pec->etablissement_id = $request->etablissement_id;
        $pec->save();

        return response()->json(['pec'=>$pec]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\pec  $pec
     * @return \Illuminate\Http\Response
     */
    public function show(pec $pec)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\pec  $pec
     * @return \Illuminate\Http\Response
     */
    public function edit(pec $pec)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\pec  $pec
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, pec $pec)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\pec  $pec
     * @return \Illuminate\Http\Response
     */
    public function destroy(pec $pec)
    {
        //
    }
}
