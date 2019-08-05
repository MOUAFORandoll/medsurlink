<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\ConclusionRequest;
use App\Models\Conclusion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ConclusionController extends Controller
{
    protected $table = "conclusions";

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $conclusions = Conclusion::all();
        return response()->json(['conclusions'=>$conclusions]);
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
    public function store(ConclusionRequest $request)
    {
        $conclusion = Conclusion::create($request->validated());
        defineAsAuthor("Conclusion",$conclusion->id,'create');

        return response()->json(['conclusion'=>$conclusion]);

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

        $conclusion = Conclusion::with('consultation')->find($id);
        return response()->json(['conclusion'=>$conclusion]);

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
    public function update(ConclusionRequest $request, $id)
    {
        $validation = validatedId($id,$this->table);
        if(!is_null($validation))
            return $validation;

        $isAuthor = checkIfIsAuthorOrIsAuthorized("ConsutationMedecine",$id,"create");
        if($isAuthor->getOriginalContent() == false){
            return response()->json(['error'=>"Vous ne pouvez modifié un élement que vous n'avez crée"],401);
        }

        Conclusion::whereId($id)->update($request->validated());
        $conclusion = Conclusion::with('consultation')->find($id);
        return response()->json(['conclusion'=>$conclusion]);
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

        $conclusion = Conclusion::with('consultation')->find($id);
        Conclusion::destroy($id);
        return response()->json(['conclusion'=>$conclusion]);
    }
}
