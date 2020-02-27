<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\PersonnalErrors;
use App\Http\Requests\MedicamentRequest;
use App\Models\Medicament;

class MedicamentController extends Controller
{
    use PersonnalErrors;
    protected $table = "medicaments";
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $medicaments = Medicament::all();
        return response()->json(['medicaments'=>$medicaments]);
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
    public function store(MedicamentRequest $request)
    {
        $medicament  = Medicament::create($request->validated());
        defineAsAuthor('Medicament',$medicament->id,'create');

        return response()->json(['medicament'=>$medicament]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $this->validatedSlug($slug,$this->table);
        $medicament = Medicament::findBySlug($slug);
        $medicament->updateMedicament();
        return response()->json(['medicament'=>$medicament]);
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
    public function update(MedicamentRequest $request, $slug)
    {
        $this->validatedSlug($slug,$this->table);
        Medicament::whereSlug($slug)->update($request->validated());

        $medicament = Medicament::findBySlug($slug);
        defineAsAuthor('Medicament',$medicament->id,'update');

        return response()->json(['medicament'=>$medicament]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        $this->validatedSlug($slug,$this->table);

        $medicament = Medicament::findBySlug($slug);
        $medicament->delete();

        defineAsAuthor('Medicament',$medicament->id,'delete');

    }
}
