<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\SpecialiteRequest;
use App\Models\Specialite;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Netpok\Database\Support\DeleteRestrictionException;

class SpecialiteController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $specialites = Specialite::with('profession')->get();
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
        defineAsAuthor("Specialite",$specialite->id,'create');

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
        $validation = $this->validatedId($id);
        if(!is_null($validation))
            return $validation;

        $specialite = Specialite::with('profession')->find($id);
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
        $validation = $this->validatedId($id);
        if(!is_null($validation))
            return $validation;

        Specialite::whereId($id)->update($request->validated());
        $specialite = Specialite::with('profession')->find($id);
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
        $validation = $this->validatedId($id);
        if(!is_null($validation))
            return $validation;

        try{
            $specialite = Specialite::with('profession')->find($id);
            $specialite->delete();
            return response()->json(['specialite'=>$specialite]);
        }catch (DeleteRestrictionException $deleteRestrictionException){
            return response()->json(['error'=>$deleteRestrictionException->getMessage()],422);
        }

    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function validatedId($id){
        $validation = Validator::make(compact('id'),['id'=>'exists:specialites,id']);
        if ($validation->fails()){
            return response()->json($validation->errors(),422);
        }
        return null;
    }
}
