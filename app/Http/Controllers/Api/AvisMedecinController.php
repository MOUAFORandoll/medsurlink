<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Traits\PersonnalErrors;
use App\Http\Requests\AvisMedecinRequest;
use App\Models\Avis;
use App\Models\MedecinAvis;
use App\Traits\DossierTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AvisMedecinController extends Controller
{
    use PersonnalErrors;
    use DossierTrait;

    protected $table = 'medecin_avis';
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
    public function store(AvisMedecinRequest $request,$slug)
    {
        $this->validatedSlug($slug,$this->table);

        $avis = MedecinAvis::whereSlug($slug)->first();

        $avis->view = $request->view;
        $avis->avis = $request->avis;
        $avis->statut = $request->get('statut','NON VALIDE');
        if (!is_null($request->avis)){
            if (strlen($request->avis) > 0){
                $avis->set_opinion_at = Carbon::now()->format('Y-m-d H:i:s');
            }
        }
        $avis->save();
        $this->updateDossierId($avis->avisMedecin->dossier->id);
        return  response()->json(['avis'=>$avis]);
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

        $avis = MedecinAvis::whereSlug($slug)->first();

        return  response()->json(['avis'=>$avis]);
    }

    public function repondre($aviSlug){
        $medecin = Auth::id();

        $this->validatedSlug($aviSlug,'avis');
        $avis = Avis::whereSlug($aviSlug)->first();

        $medecin_avis = MedecinAvis::where('avis_id',$avis->id)->where('medecin_id',$medecin)->first();
        $medecin_avis->view = 1;
        $medecin_avis->save();

        $this->updateDossierId($avis->dossier->id);

        return response()->json(['avis'=>$medecin_avis]);
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

    public function NouveauAvis(AvisMedecinRequest $request,$slug){
        $this->validatedSlug($slug,'avis');
        $avis = Avis::whereSlug($slug)->first();

       $avis =  MedecinAvis::create($request->all() + [
                "avis_id"=>$avis->id,
                "medecin_id"=>Auth::id(),
                "set_opinion_at"=>Carbon::now()->format('Y-m-d H:i:s'),
            ]);

        $this->updateDossierId($avis->avisMedecin->dossier->id);

        return  response()->json(['avis'=>$avis]);
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

        $avis = MedecinAvis::whereSlug($slug)->first();
        $avis->delete();

        $this->updateDossierId($avis->avisMedecin->dossier->id);

        return  response()->json(['avis'=>$avis]);
    }
}
