<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\ReponseSecreteRequest;
use App\Models\ReponseSecrete;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReponseSecreteController extends Controller
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
        //
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
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function update(ReponseSecreteRequest $request, $slug)
    {
        $questionReponse = ReponseSecrete::where('user_id','=',$slug)->first();
        ReponseSecrete::whereId($questionReponse->id)->update($request->validated());
        $questionReponse = ReponseSecrete::with('user','question')->where('user_id','=',$slug)->first();

        return response()->json(['question'=>$questionReponse]);
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
