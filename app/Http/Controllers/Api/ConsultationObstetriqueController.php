<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\PersonnalErrors;
use App\Http\Requests\ConsultationObstetriqueRequest;
use App\Models\ConsultationObstetrique;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Netpok\Database\Support\DeleteRestrictionException;

class ConsultationObstetriqueController extends Controller
{
    use PersonnalErrors;
    protected $table =  "consultation_obstetriques";
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $consultationsObstetrique = ConsultationObstetrique::with(['consultationPrenatales', 'dossier'])->orderByDateDeRendezVous()->get();

        foreach ($consultationsObstetrique as $consultationObstetrique){
            $consultationObstetrique->updateObstetricConsultation();
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
     * @param ConsultationObstetriqueRequest $request
     * @return \Illuminate\Http\Response
     * @throws \App\Exceptions\PersonnnalException
     */
    public function store(ConsultationObstetriqueRequest $request)
    {


        $maxNumeroGrossesse = self::genererNumeroGrossesse($request->dossier_medical_id);
        $user = Auth::user();
        $serologie = implode(" ",$request->serologie);
        if($user->hasRole('Praticien')){
            $praticen = $user->praticien;
            if ($praticen->specialite->name == "Gynéco-obstétrique"){

                $consultationObstetrique =  ConsultationObstetrique::create($request->except('serologie')+['numero_grossesse'=>$maxNumeroGrossesse,'serologie'=>$serologie]);

                defineAsAuthor("ConsultationObstetrique",$consultationObstetrique->id,'create',$consultationObstetrique->dossier->patient->user_id);

                return response()->json(['consultationObstetrique'=>$consultationObstetrique]);

            }else{
                $this->revealAccesRefuse();
            }
        }elseif($user->hasRole('Admin')){
            $consultationObstetrique =  ConsultationObstetrique::create($request->except('serologie')+['numero_grossesse'=>$maxNumeroGrossesse,'serologie'=>$serologie]);

            defineAsAuthor("ConsultationObstetrique",$consultationObstetrique->id,'create',$consultationObstetrique->dossier->patient->user_id);

            return response()->json(['consultationObstetrique'=>$consultationObstetrique]);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param $slug
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function show($slug)
    {
         $this->validatedSlug($slug,$this->table);

        $consultationObstetrique =  ConsultationObstetrique::with(['consultationPrenatales','echographies','dossier'])->whereSlug($slug)->first();
        $consultationObstetrique->updateObstetricConsultation();

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
     * @param ConsultationObstetriqueRequest $request
     * @param $slug
     * @return \Illuminate\Http\Response
     * @throws \App\Exceptions\PersonnnalException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(ConsultationObstetriqueRequest $request, $slug)
    {


        $this->validatedSlug($slug,$this->table);

        $consultationObstetrique = ConsultationObstetrique::findBySlug($slug);

        $this->checkIfAuthorized("ConsultationObstetrique",$consultationObstetrique->id,"create");

        $numeroGrossesse = $consultationObstetrique->numero_grossesse;
        $serologie = implode(" ",$request->serologie);
        ConsultationObstetrique::whereSlug($slug)->update($request->except('serologie')+['numero_grossesse'=>$numeroGrossesse,'serologie'=>$serologie]);

        $consultationObstetrique =  ConsultationObstetrique::with(['consultationPrenatales','echographies','dossier'])->whereSlug($slug)->first();

        return response()->json(['consultationObstetrique'=>$consultationObstetrique]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $slug
     * @return \Illuminate\Http\Response
     * @throws \App\Exceptions\PersonnnalException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function destroy($slug)
    {
        $this->validatedSlug($slug,$this->table);

        $consultationObstetrique = ConsultationObstetrique::findBySlug($slug);

        $this->checkIfAuthorized("ConsultationObstetrique",$consultationObstetrique->id,"create");

        try{
            $consultationObstetrique =  ConsultationObstetrique::with(['consultationPrenatales','echographies','dossier'])->whereSlug($slug)->first();
            $consultationObstetrique->delete();
            return response()->json(['consultationObstetrique'=>$consultationObstetrique]);
        }catch (DeleteRestrictionException $deleteRestrictionException){
            $this->revealError('deletingError',$deleteRestrictionException->getMessage());
        }
    }

    /**
     * Archieved the specified resource in storage.
     *
     * @param $slug
     * @return \Illuminate\Http\Response
     * @throws \App\Exceptions\PersonnnalException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function archiver($slug)
    {
        $this->validatedSlug($slug,$this->table);

        $resultat = ConsultationObstetrique::with(['consultationPrenatales','echographies','dossier'])->whereSlug($slug)->first();
        if (is_null($resultat->passed_at)){
            $this->revealNonTransmis();
        }else{
            $resultat->archieved_at = Carbon::now();
            $resultat->save();
            defineAsAuthor("ConsultationObstetrique",$resultat->id,'archive');
            return response()->json(['resultat'=>$resultat]);
        }
    }

    /**
     * Passed the specified resource in storage.
     *
     * @param $slug
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function transmettre($slug)
    {
        $this->validatedSlug($slug,$this->table);

        $resultat = ConsultationObstetrique::with(['consultationPrenatales','echographies','dossier'])->whereSlug($slug)->first();
        $resultat->passed_at = Carbon::now();
        $resultat->save();
        defineAsAuthor("ConsultationObstetrique",$resultat->id,'transmettre');

        return response()->json(['resultat'=>$resultat]);

    }

    /**
     * @return int|mixed
     */
    public static function genererNumeroGrossesse($dossier){
        $maxConsultationObst =  DB::table('consultation_obstetriques')->where('dossier_medical_id','=',$dossier)->max('numero_grossesse');
        return $maxConsultationObst +1;
    }
}
