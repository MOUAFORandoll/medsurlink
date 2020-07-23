<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Traits\PersonnalErrors;
use App\Http\Requests\ComptableRequest;
use App\Models\Comptable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ComptableController extends Controller
{
    use PersonnalErrors;
    protected $table = 'comptables';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comptables = Comptable::with('etablissements','user')->get();
        return response()->json(['comptables'=>$comptables]);
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
    public function store(ComptableRequest $request)
    {
        $comptable = Comptable::create($request->all());

        return  response()->json(['comptable'=>$comptable]);
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function show(string $slug)
    {
        $this->validatedSlug($slug, $this->table);

        $comptable = Comptable::with('user','etablissements')->whereSlug($slug)->first();

        return response()->json(['comptable'=>$comptable]);
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
    public function update(ComptableRequest $request, $slug)
    {
        $this->validatedSlug($slug, $this->table);

        Comptable::whereSlug($slug)->update($request->all());

        $comptable = Comptable::with('user','etablissements')->whereSlug($slug)->first();

        return response()->json(['comptable'=>$comptable]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {

        $this->validatedSlug($slug, $this->table);

        $comptable = Comptable::with('user','etablissements')->whereSlug($slug)->first();

        if (!is_null($comptable))
            $comptable->delete();

        return response()->json(['comptable'=>$comptable]);
    }
}
