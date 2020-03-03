<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Traits\PersonnalErrors;
use App\Http\Requests\ExamenCardioRequest;
use App\Models\Cardiologie;
use App\Models\ExamenCardio;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ExamenCardioController extends Controller
{
    use PersonnalErrors;
    protected $table = 'examen_cardios';

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
    public function store(ExamenCardioRequest $request)
    {
        $cardiologie = Cardiologie::whereSlug($request->get('cardiologie_id'))->first();
        $examenCardio = ExamenCardio::create($request->except('cardiologie_id') + ['cardiologie_id'=>$cardiologie->id]);
        defineAsAuthor("ExamenCardio", $examenCardio->id, 'create', $cardiologie->dossier->patient->user_id);

        $examen = ExamenCardio::with('cardiologie')->whereSlug($examenCardio->slug)->first();
        $examen->updateExamen();
        return  response()->json(['examen'=>$examen]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $examen = ExamenCardio::with('cardiologie')->whereSlug($slug)->first();
        $examen->updateExamen();
        return  response()->json(['examen'=>$examen]);
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
    public function update(ExamenCardioRequest $request, $slug)
    {
        $this->validatedSlug($slug,$this->table);
        ExamenCardio::whereSlug($slug)->update($request->validated());
        $examen = ExamenCardio::with('cardiologie')->whereSlug($slug)->first();
        $examen->updateExamen();
        defineAsAuthor("ExamenCardio", $examen->id, 'update', $examen->cardiologie->dossier->patient->user_id);
        return  response()->json(['examen'=>$examen]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        $examen = ExamenCardio::with('cardiologie')->whereSlug($slug)->first();
        $examen->updateExamen();
        $examen->delete();
        defineAsAuthor("ExamenCardio", $examen->id, 'update', $examen->cardiologie->dossier->patient->user_id);
        return  response()->json(['examen'=>$examen]);
    }
}
