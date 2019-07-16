<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\ProfessionRequest;
use App\Models\Profession;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ProfessionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $professions = Profession::all();
        return response()->json(['professions'=>$professions]);
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
    public function store(ProfessionRequest $request)
    {
        $profession = Profession::create($request->validated());
        return response()->json(['profession'=>$profession]);
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
        $profession = Profession::find($id);
        return response()->json(['profession'=>$profession]);

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
    public function update(ProfessionRequest $request, $id)
    {
        $this->validatedId($id);
        Profession::whereId($id)->update($request->validated());
        $profession = Profession::find($id);
        return response()->json(['profession'=>$profession]);
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
        $profession = Profession::find($id);
        Profession::destroy($id);
        return response()->json(['profession'=>$profession]);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function validatedId($id){
        $validation = Validator::make(compact('id'),['id'=>'exists:professions,id']);
        if ($validation->fails()){
            return response()->json(['id'=>$validation->errors()],422);
        }
    }
}
