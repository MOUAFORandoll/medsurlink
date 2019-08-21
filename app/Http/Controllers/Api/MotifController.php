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
        if ($request->has('error'))
        {
            return  response()->json(['error'=>$request->all()['error']],419);
        }

        $motif = Motif::create($request->validated());
        defineAsAuthor("Motif",$motif->id,'create');

        return response()->json(['motif'=>$motif]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $validation = validatedSlug($slug,$this->table);
        if(!is_null($validation))
            return $validation;

        $motif = Motif::findBySlug($slug);
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
    public function update(MotifRequest $request, $slug)
    {
        if ($request->has('error'))
        {
            return  response()->json(['error'=>$request->all()['error']],419);
        }

        $validation = validatedSlug($slug,$this->table);
        if(!is_null($validation))
            return $validation;

        $motif = Motif::findBySlug($slug);
        $isAuthor = checkIfIsAuthorOrIsAuthorized("Motif",$motif->id,"create");
        if($isAuthor->getOriginalContent() == false){
            return response()->json(['error'=>"Vous ne pouvez modifié un élement que vous n'avez crée"],401);
        }

        $motif = Motif::whereSlug($slug)->update($request->validated());

        $motif = Motif::findBySlug($slug);
        return response()->json(['motif'=>$motif]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        $validation = validatedSlug($slug,$this->table);
        if(!is_null($validation))
            return $validation;

        $motif  = Motif::findBySlug($slug);
        $isAuthor = checkIfIsAuthorOrIsAuthorized("Motif",$slug,"create");
        if($isAuthor->getOriginalContent() == false){
            return response()->json(['error'=>"Vous ne pouvez modifié un élement que vous n'avez crée"],401);
        }

        $motif = Motif::findBySlug($slug);
        $motif->delete();
        return response()->json(['motif'=>$motif]);
    }
}
