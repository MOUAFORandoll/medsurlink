<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\MotifRequest;
use App\Models\Motif;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MotifController extends Controller
{
    protected $table = "motifs";
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $motifs = Motif::all();
        return response()->json(['motifs'=>$motifs]);
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
    public function store(MotifRequest $request)
    {
        $motif = Motif::create($request->validated());
        return response()->json(['motif'=>$motif]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $validation = validatedId($id,$this->table);
        if(!is_null($validation))
            return $validation;

        $motif = Motif::find($id);
        return response()->json(['motif'=>$motif]);
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
    public function update(MotifRequest $request, $id)
    {
        $validation = validatedId($id,$this->table);
        if(!is_null($validation))
            return $validation;

        $motif = Motif::whereId($id)->update($request->validated());

        $motif = Motif::find($id);
        return response()->json(['motif'=>$motif]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $validation = validatedId($id,$this->table);
        if(!is_null($validation))
            return $validation;

        $motif = Motif::find($id);
        Motif::destroy($id);
        return response()->json(['motif'=>$motif]);
    }
}
