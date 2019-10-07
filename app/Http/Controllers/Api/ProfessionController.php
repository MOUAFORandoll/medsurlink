<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\PersonnalErrors;
use App\Http\Requests\ProfessionRequest;
use App\Models\Profession;
use Netpok\Database\Support\DeleteRestrictionException;

class ProfessionController extends Controller
{
    use PersonnalErrors;
    protected $table = "professions";
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $professions = Profession::with('specialites')->get();
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

        defineAsAuthor("Profession",$profession->id,'create');

        return response()->json(['profession'=>$profession]);
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

        $profession = Profession::with('specialites')->whereSlug($slug)->first();

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
     * @param ProfessionRequest $request
     * @param $slug
     * @return \Illuminate\Http\Response
     * @throws \App\Exceptions\PersonnnalException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(ProfessionRequest $request, $slug)
    {
         $this->validatedSlug($slug,$this->table);

        $profession  = Profession::whereSlug($slug)->first();

        $this->checkIfAuthorized("Profession",$profession->id,"create");

        Profession::whereSlug($slug)->update($request->validated());

        $profession = Profession::with('specialites')->whereSlug($slug)->first();

        return response()->json(['profession'=>$profession]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $slug
     * @return \Illuminate\Http\Response
     * @throws \App\Exceptions\PersonnnalException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function destroy($slug)
    {
        $this->validatedSlug($slug,$this->table);

        $profession  = Profession::whereSlug($slug)->first();

        $this->checkIfAuthorized("Profession",$profession->id,"create");

        try{
            $profession = Profession::with('specialites')->whereSlug($slug)->first();
            $profession->delete();

        }catch (DeleteRestrictionException $deleteRestrictionException){
            return response()->json(['error'=>$deleteRestrictionException->getMessage()],422);
        }
        return response()->json(['profession'=>$profession]);
    }

}
