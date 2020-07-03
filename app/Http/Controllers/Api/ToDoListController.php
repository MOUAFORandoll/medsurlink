<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Traits\PersonnalErrors;
use App\Http\Requests\ToDoListRequest;
use App\Models\SuiviToDoList;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ToDoListController extends Controller
{
    use PersonnalErrors;
    protected $table = 'suivi_to_do_lists';
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
    public function store(ToDoListRequest $request)
    {
        $toDo = SuiviToDoList::create($request->all());
        $toDo = SuiviToDoList::with('listable')->whereSlug($toDo->slug)->first();
        return response()->json(['toDo'=>$toDo]);
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $this->validatedSlug($slug, $this->table);

        $toDo = SuiviToDoList::with('listable')->whereSlug($slug)->first();

        return response()->json(['toDo'=>$toDo]);
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
    public function update(ToDoListRequest $request, $slug)
    {
        $this->validatedSlug($slug, $this->table);

        SuiviToDoList::whereSlug($slug)->update($request->all());

        $toDo = SuiviToDoList::with('listable')->whereSlug($slug)->first();

        return response()->json(['toDo'=>$toDo]);
    }

    public function updateStatut(Request $request, $slug){

        $this->validatedSlug($slug, $this->table);

        $statut = $request->get('statut');

        SuiviToDoList::whereSlug($slug)->update(['statut'=>$statut]);

        $toDo = SuiviToDoList::with('listable')->whereSlug($slug)->first();

        return response()->json(['toDo'=>$toDo]);

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

        $toDo = SuiviToDoList::with('listable')->whereSlug($slug)->first();

        if (!is_null($toDo)){
            $toDo->delete();
        }

        return response()->json(['toDo'=>$toDo]);
    }
}
