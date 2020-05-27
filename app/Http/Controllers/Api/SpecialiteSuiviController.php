<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Traits\PersonnalErrors;
use App\Http\Requests\SpecialiteSuiviRequest;
use App\Models\ConsultationType;
use App\Models\SpecialiteSuivi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SpecialiteSuiviController extends Controller
{
    use PersonnalErrors;

    protected $table = "specialite_suivis";

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
    public function store(SpecialiteSuiviRequest $request)
    {
        $specialiteSuivi = SpecialiteSuivi::create($request->all());

        return  response()->json(['specialiteSuivi'=>$specialiteSuivi]);
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $this->validatedSlug($slug,$this->table);

        $specialiteSuivi = SpecialiteSuivi::whereSlug($slug)->first();

        return  response()->json(['specialiteSuivi'=>$specialiteSuivi]);
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
    public function update(SpecialiteSuiviRequest $request, $slug)
    {
        $this->validatedSlug($slug,$this->table);

        SpecialiteSuivi::whereSlug($slug)->update($request->all());

        $specialiteSuivi = SpecialiteSuivi::whereSlug($slug)->first();

        return  response()->json(['specialiteSuivi'=>$specialiteSuivi]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        $this->validatedSlug($slug,$this->table);

        $specialiteSuivi = SpecialiteSuivi::whereSlug($slug)->first();

        $specialiteSuivi->delete();

        return  response()->json(['specialiteSuivi'=>$specialiteSuivi]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function deleteAllSpecialities(Request $request)
    {
        SpecialiteSuivi::where('suivi_id', $request->id)->delete();

        return  response()->json(['suivi'=> 'done']);
    }
}
