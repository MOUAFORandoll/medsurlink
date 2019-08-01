<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\ConsultationObstetriqueRequest;
use App\Models\ConsultationObstetrique;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ConsultationObstetriqueController extends Controller
{
    protected $table =  "consultation_obstetriques";
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $consultationsObstetrique = ConsultationObstetrique::all();
        return response()->json(['consultationsObstetrique'=>$consultationsObstetrique]);
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
    public function store(ConsultationObstetriqueRequest $request)
    {
        $user = Auth::user();
        if($user->hasRole('Praticien')){
            $praticen = $user->praticien;
            if ($praticen->specialite->name == "Gynéco-obstétrique"){
                $consultationObstetrique =  ConsultationObstetrique::create($request->validated());
                defineAsAuthor("ConsultationObstetrique",$consultationObstetrique->id,'create');
                return response()->json(['consultationObstetrique'=>$consultationObstetrique]);
            }else{
                return response()->json(['error'=>"Vous ne disposez pas des autorisations pour effectuer cette action"],422);
            }
        }elseif($user->hasRole('Admin')){
            $consultationObstetrique =  ConsultationObstetrique::create($request->validated());
            defineAsAuthor("ConsultationObstetrique",$consultationObstetrique->id,'create');
            return response()->json(['consultationObstetrique'=>$consultationObstetrique]);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $validation = validatedId($id,$this->table);
        if(!is_null($validation))
            return $validation;

        $consultationObstetrique =  ConsultationObstetrique::find($id);
        return response()->json(['consultationObstetrique'=>$consultationObstetrique]);
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
    public function update(ConsultationObstetriqueRequest $request, $id)
    {
        $validation = validatedId($id,$this->table);
        if(!is_null($validation))
            return $validation;

        ConsultationObstetrique::whereId($id)->update($request->validated());
        $consultationObstetrique =  ConsultationObstetrique::find($id);
        return response()->json(['consultationObstetrique'=>$consultationObstetrique]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $validation = validatedId($id,$this->table);
        if(!is_null($validation))
            return $validation;

        $consultationObstetrique =  ConsultationObstetrique::find($id);
        ConsultationObstetrique::destroy($id);
        return response()->json(['consultationObstetrique'=>$consultationObstetrique]);
    }
}
