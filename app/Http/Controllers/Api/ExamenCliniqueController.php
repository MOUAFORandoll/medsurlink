<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\ExamenCliniqueRequest;
use App\Models\ExamenClinique;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ExamenCliniqueController extends Controller
{
    protected $table = "examen_cliniques";

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $examensClinique = ExamenClinique::all();
        return response()->json(['examensClinique'=>$examensClinique]);
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
    public function store(ExamenCliniqueRequest $request)
    {
        if ($request->has('error'))
        {
            return  response()->json(['error'=>$request->all()['error']],419);
        }

        $examenClinique = ExamenClinique::create($request->validated());
        defineAsAuthor("ExamenClinique",$examenClinique->id,'create');

        return response()->json(['examenClinique'=>$examenClinique]);

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

        $examenClinique = ExamenClinique::whereSlug($slug)->first();
        return response()->json(['examenClinique'=>$examenClinique]);
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
    public function update(ExamenCliniqueRequest $request, $slug)
    {
        if ($request->has('error'))
        {
            return  response()->json(['error'=>$request->all()['error']],419);
        }

        $validation = validatedSlug($slug,$this->table);
        if(!is_null($validation))
            return $validation;

        $examenClinique = ExamenClinique::findBySlug($slug);
        $isAuthor = checkIfIsAuthorOrIsAuthorized("ExamenClinique",$examenClinique->id,"create");
        if($isAuthor->getOriginalContent() == false){
            return response()->json(['error'=>"Vous ne pouvez modifié un élement que vous n'avez crée"],401);
        }

        ExamenClinique::whereSlug($slug)->update($request->validated());
        $examenClinique = ExamenClinique::whereSlug($slug)->first();
        return response()->json(['examenClinique'=>$examenClinique]);
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
        $examenClinique = ExamenClinique::findBySlug($slug);
        $isAuthor = checkIfIsAuthorOrIsAuthorized("ExamenClinique",$examenClinique->id,"create");
        if($isAuthor->getOriginalContent() == false){
            return response()->json(['error'=>"Vous ne pouvez modifié un élement que vous n'avez crée"],401);
        }

        $examenClinique = ExamenClinique::whereSlug($slug)->first();
        $examenClinique->delete();
        return response()->json(['examenClinique'=>$examenClinique]);
    }
}
