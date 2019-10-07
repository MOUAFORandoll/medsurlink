<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Traits\PersonnalErrors;
use App\Http\Requests\SpecialiteRequest;
use App\Models\Specialite;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Netpok\Database\Support\DeleteRestrictionException;

class SpecialiteController extends Controller
{
    use PersonnalErrors;
    protected $table = "specialites";

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $specialites = Specialite::with(['profession'])->get();
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
     * @param $slug
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function show($slug)
    {
        $this->validatedSlug($slug,$this->table);

        $specialite = Specialite::with(['profession'])->whereSlug($slug)->first();

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
     * @param SpecialiteRequest $request
     * @param $slug
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(SpecialiteRequest $request, $slug)
    {

        $this->validatedSlug($slug,$this->table);

        Specialite::whereSlug($slug)->update($request->validated());

        $specialite = Specialite::with(['profession'])->whereSlug($slug)->first();

        return response()->json(['specialite'=>$specialite]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $slug
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function destroy($slug)
    {
        $this->validatedSlug($slug,$this->table);

        try{
            $specialite = Specialite::with(['profession'])->whereSlug($slug)->first();
            $specialite->delete();
            return response()->json(['specialite'=>$specialite]);
            
        }catch (DeleteRestrictionException $deleteRestrictionException){
            return response()->json(['error'=>$deleteRestrictionException->getMessage()],422);
        }

    }
}
