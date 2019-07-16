<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\SpecialiteRequest;
use App\Models\Specialite;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class SpecialiteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $specialites = Specialite::all();
        return response()->json(['specialites'=>$specialites]);
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
    public function store(SpecialiteRequest $request)
    {
        $specialite = Specialite::create($request->validated());
        return response()->json(['specialite'=>$specialite]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->validatedId($id);
        $specialite = Specialite::find($id);
        return response()->json(['specialite'=>$specialite]);

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
    public function update(SpecialiteRequest $request, $id)
    {
        $this->validatedId($id);
        Specialite::whereId($id)->update($request->validated());
        $specialite = Specialite::find($id);
        return response()->json(['specialite'=>$specialite]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->validatedId($id);
        $specialite = Specialite::find($id);
        Specialite::destroy($id);
        return response()->json(['specialite'=>$specialite]);

    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function validatedId($id){
        $validation = Validator::make(compact('id'),['id'=>'exists:specialites,id']);
        if ($validation->fails()){
            return response()->json(['id'=>$validation->errors()],422);
        }
    }
}
