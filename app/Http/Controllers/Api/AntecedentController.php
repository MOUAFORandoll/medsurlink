<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\AntecedentRequest;
use App\Models\Antecedent;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AntecedentController extends Controller
{
    protected $table = "antecedents";
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $antecedents = Antecedent::with('consultation')->get();
        return response()->json(['antecedents'=>$antecedents]);
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
    public function store(AntecedentRequest $request)
    {

        $antecedent = Antecedent::create($request->validated());
        defineAsAuthor("Antecedent",$antecedent->id,'create');

        $antecedent = Antecedent::with('consultation')->whereSlug($antecedent->slug)->first();
        return response()->json(['antecedent'=>$antecedent]);
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

        $antecedent = Antecedent::with('consultation')->whereSlug($slug)->first();
        return response()->json(['antecedent'=>$antecedent]);

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
    public function update(AntecedentRequest $request, $slug)
    {

        $validation = validatedSlug($slug,$this->table);
        if(!is_null($validation))
            return $validation;
        $antecedent = Antecedent::whereSlug($slug)->first();
        $isAuthor = checkIfIsAuthorOrIsAuthorized("Antecedent",$antecedent->id,"create");
        if($isAuthor->getOriginalContent() == false){
            $transmission = [];
            $transmission['accessRefuse'][0] = "Vous ne pouvez modifié un élement que vous n'avez crée";
            return response()->json(['error'=>$transmission],419 );
        }
        Antecedent::whereSlug($slug)->update($request->validated());
        $antecedent = Antecedent::with('consultation')->whereSlug($slug)->first();

        return response()->json(['antecedent'=>$antecedent]);
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

        $antecedent = Antecedent::whereSlug($slug)->first();
        $isAuthor = checkIfIsAuthorOrIsAuthorized("Antecedent",$antecedent->id,"create");
        if($isAuthor->getOriginalContent() == false){
            $transmission = [];
            $transmission['accessRefuse'][0] = "Vous ne pouvez modifié un élement que vous n'avez crée";
            return response()->json(['error'=>$transmission],419 );
        }

        $antecedent = Antecedent::with('consultation')->whereSlug($slug)->first();
        $antecedent->delete();
        return response()->json(['antecedent'=>$antecedent]);
    }
}
