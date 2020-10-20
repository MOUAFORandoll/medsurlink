<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Traits\PersonnalErrors;
use App\Http\Requests\ActiviteRequest;
use App\Models\Activite;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ActiviteController extends Controller
{
    use PersonnalErrors;
    public $table = 'activites';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $activites = Activite::all();
        return  response()->json(['activites'=>$activites]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ActiviteRequest $request)
    {
        $activite = Activite::create($request->all());

        return response()->json(['activite'=>$activite]);
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

        $activite = Activite::whereSlug($slug)->first();

        return response()->json(['activite'=>$activite]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function update(ActiviteRequest $request, $slug)
    {
        $this->validatedSlug($slug,$this->table);

        Activite::whereSlug($slug)->update($request->except('activite'));

        $activite = Activite::whereSlug($slug)->first();

        return response()->json(['activite'=>$activite]);
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

        $activite = Activite::whereSlug($slug)->first();

        $activite->delete();

        return response()->json(['activite'=>$activite]);
    }
}
