<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\ConsultationObstetriqueRequest;
use App\Models\ConsultationObstetrique;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Netpok\Database\Support\DeleteRestrictionException;

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
        $consultationsObstetrique = ConsultationObstetrique::with(['consultationPrenatales', 'echographies', 'dossier'])->get();
        foreach ($consultationsObstetrique as $consultationObstetrique){
            $user = $consultationObstetrique->dossier->patient->user;
            $consultationObstetrique['user']=$user;
        }
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


        $maxNumeroGrossesse = self::genererNumeroGrossesse();
        $user = Auth::user();
        if($user->hasRole('Praticien')){
            $praticen = $user->praticien;
            if ($praticen->specialite->name == "Gynéco-obstétrique"){
                $consultationObstetrique =  ConsultationObstetrique::create($request->validated()+['numero_grossesse'=>$maxNumeroGrossesse]);

                defineAsAuthor("ConsultationObstetrique",$consultationObstetrique->id,'create');

                return response()->json(['consultationObstetrique'=>$consultationObstetrique]);
            }else{
                $transmission = [];
                $transmission['accessRefuse'][0] = "Vous ne pouvez effectuer cette action";
                return response()->json(['error'=>$transmission],419 );}
        }elseif($user->hasRole('Admin')){
            $consultationObstetrique =  ConsultationObstetrique::create($request->validated()+['numero_grossesse'=>$maxNumeroGrossesse]);
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
    public function show($slug)
    {
        $validation = validatedSlug($slug,$this->table);
        if(!is_null($validation))
            return $validation;

        $consultationObstetrique =  ConsultationObstetrique::with(['consultationPrenatales','echographies','dossier'])->whereSlug($slug)->first();
        $user = $consultationObstetrique->dossier->patient->user;
        $consultationObstetrique['user']=$user;
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
    public function update(ConsultationObstetriqueRequest $request, $slug)
    {


        $validation = validatedSlug($slug,$this->table);
        if(!is_null($validation))
            return $validation;
        $consultationObstetrique = ConsultationObstetrique::findBySlug($slug);

        $isAuthor = checkIfIsAuthorOrIsAuthorized("ConsultationObstetrique",$consultationObstetrique->id,"create");
        if($isAuthor->getOriginalContent() == false){
            $transmission = [];
            $transmission['accessRefuse'][0] = "Vous ne pouvez modifié un élement que vous n'avez crée";
            return response()->json(['error'=>$transmission],419 ); }

        $numeroGrossesse = $consultationObstetrique->numero_grossesse;
        ConsultationObstetrique::whereSlug($slug)->update($request->validated() + ['numero_grossesse'=>$numeroGrossesse]);
        $consultationObstetrique =  ConsultationObstetrique::with(['consultationPrenatales','echographies','dossier'])->whereSlug($slug)->first();
        return response()->json(['consultationObstetrique'=>$consultationObstetrique]);
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

        $consultationObstetrique = ConsultationObstetrique::findBySlug($slug);
        $isAuthor = checkIfIsAuthorOrIsAuthorized("ConsultationObstetrique",$consultationObstetrique->id,"create");
        if($isAuthor->getOriginalContent() == false){
            $transmission = [];
            $transmission['accessRefuse'][0] = "Vous ne pouvez modifié un élement que vous n'avez crée";
            return response()->json(['error'=>$transmission],419 ); }
        try{
            $consultationObstetrique =  ConsultationObstetrique::with(['consultationPrenatales','echographies','dossier'])->whereSlug($slug)->first();
            $consultationObstetrique->delete();
            return response()->json(['consultationObstetrique'=>$consultationObstetrique]);
        }catch (DeleteRestrictionException $deleteRestrictionException){
            return response()->json(['error'=>$deleteRestrictionException->getMessage()],422);
        }
    }

    /**
     * Archieved the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function archiver($slug)
    {
        $validation = validatedSlug($slug,$this->table);
        if(!is_null($validation))
            return $validation;

        $resultat = ConsultationObstetrique::with(['consultationPrenatales','echographies','dossier'])->whereSlug($slug)->first();
        if (is_null($resultat->passed_at)){
            $transmission = [];
            $transmission['nonTransmis'][0] = "Ce resultat n'a pas encoré été transmis";
            return response()->json(['error'=>$transmission],419 );
        }else{
            $resultat->archieved_at = Carbon::now();
            $resultat->save();
            return response()->json(['resultat'=>$resultat]);
        }
    }

    /**
     * Passed the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function transmettre($slug)
    {
        $validation = validatedSlug($slug,$this->table);
        if(!is_null($validation))
            return $validation;

        $resultat = ConsultationObstetrique::with(['consultationPrenatales','echographies','dossier'])->whereSlug($slug)->first();
        $resultat->passed_at = Carbon::now();
        $resultat->save();

        return response()->json(['resultat'=>$resultat]);

    }

    public static function genererNumeroGrossesse(){
        $maxConsultationObst =  DB::table('consultation_obstetriques')->max('numero_grossesse');
        return $maxConsultationObst +1;
    }
}
