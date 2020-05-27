<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\PersonnalErrors;
use App\Http\Requests\SpecialiteRequest;
use App\Models\ConsultationType;
use Netpok\Database\Support\DeleteRestrictionException;

class ConsultationTypeController extends Controller
{
    use PersonnalErrors;
    protected $table = "consultation_types";

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $specialites = ConsultationType::with(['profession'])->get();
        return response()->json(['consultationTypes'=>$specialites]);
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
        $specialite = ConsultationType::create($request->validated());

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

        $specialite = ConsultationType::with(['profession'])->whereSlug($slug)->first();

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

        ConsultationType::whereSlug($slug)->update($request->validated());

        $specialite = ConsultationType::with(['profession'])->whereSlug($slug)->first();

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
            $specialite = ConsultationType::with(['profession'])->whereSlug($slug)->first();
            $specialite->delete();
            return response()->json(['specialite'=>$specialite]);

        }catch (DeleteRestrictionException $deleteRestrictionException){
            $this->revealError('deletingError',$deleteRestrictionException->getMessage());
        }

    }
}
