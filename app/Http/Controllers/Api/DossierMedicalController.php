<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\DossierMedicalRequest;
use App\Models\DossierMedical;
use Carbon\Carbon;
use function GuzzleHttp\Psr7\str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DossierMedicalController extends Controller
{
    protected $table = 'dossier_medicals';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware(['role_or_permission:Admin|Gestionnaire']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dossiers = DossierMedical::all();
        return response()->json(['dossiers'=>$dossiers]);
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
    public function store(DossierMedicalRequest $request)
    {
        $numero_dossier = $this->randomNumeroDossier();
        $dossier = DossierMedical::create([
           'patient_id'=>$request->get('patient_id'),
            "date_de_creation"=>Carbon::today()->format('Y-m-d'),
            "numero_dossier"=>$numero_dossier,
        ]);

        return response()->json(['dossier'=>$dossier]);
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

        $dossier = DossierMedical::find($id);
        return response()->json(['dossier'=>$dossier]);
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
    public function update(Request $request, $id)
    {
        //
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

        $dossier = DossierMedical::find($id);
        DossierMedical::destroy($id);
        return response()->json(['dossier'=>$dossier]);
    }


    public function randomNumeroDossier(){
$resultat = ''.rand(0,100000000);
        while (strlen($resultat)<8){
            $longueur = strlen($resultat);
            if ($longueur == 1)
                $resultat = $resultat.''.rand(0,10000000);
            elseif ($longueur == 2 )
                $resultat = $resultat.''.rand(0,1000000);
            elseif ($longueur == 3 )
                $resultat = $resultat.''.rand(0,100000);
            elseif ($longueur == 4 )
                $resultat = $resultat.''.rand(0,10000);
            elseif ($longueur == 5 )
                $resultat = $resultat.''.rand(0,1000);
            elseif ($longueur == 6 )
                $resultat = $resultat.''.rand(0,100);
            elseif ($longueur == 7 )
                $resultat = $resultat.''.rand(0,10);

        }

        while(count(DossierMedical::where('numero_dossier','=',$resultat)->get())>0){
           $resultat = $this->randomNumeroDossier();
       }

        return $resultat;
    }



}
