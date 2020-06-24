<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\AvisRequest;
use App\Mail\AvisDemande;
use App\Models\Avis;
use App\Models\MedecinAvis;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class AvisController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $avis = Avis::with(['dossier.patient.user','medecinAvis.medecin','createur'])->get();
        return response()->json(['avis'=>$avis]);
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
    public function store(AvisRequest $request)
    {
        $avis = Avis::create($request->except('medecins'));

        $medecins = $request->get('medecins');
        if (!is_null($medecins)){
            foreach ($medecins as $medecin){
                MedecinAvis::create(['medecin_id'=>$medecin,'avis_id'=>$avis->id]);
               $user= User::whereId($medecin)->first();
               $mail = new AvisDemande($user, $avis);
               Mail::to($user->email)->send($mail);
             }
        }

        $avis = Avis::with(['dossier.patient.user','medecinAvis.medecin'])->find($avis->id);

        return response()->json(['avis'=>$avis]);
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $avis = Avis::with(['dossier.patient.user','medecinAvis.medecin','createur'])->whereSlug($slug)->first();

        return response()->json(['avis'=>$avis]);
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
    public function update(AvisRequest $request, $slug)
    {
        //Modification de l'avis
        Avis::whereSlug($slug)->update($request->except('medecins'));

        $avis = Avis::with(['dossier.patient.user','medecinAvis'])->whereSlug($slug)->first();

        $precedentMedecins = ($avis->medecinAvis->pluck('medecin_id'))->toArray();
        $nouveauMedecins = $request->get('medecins',[]);

        //Si ce n'est pas null
        if (!is_null($nouveauMedecins)){
            //Ici on va ajouter les nouveau medecin
            foreach (array_diff($nouveauMedecins,$precedentMedecins) as $medecin){
                MedecinAvis::create(['medecin_id'=>$medecin,'avis_id'=>$avis->id]);
                $user= User::whereId($medecin)->first();
                $mail = new AvisDemande($user, $avis);
                Mail::to($user->email)->send($mail);
            }
            //Ici on va retirer les anciens medecins qui ne sont pas parmis les nouveaux
            foreach (array_diff($precedentMedecins,$nouveauMedecins) as $medecin){
                $medecinAvis = MedecinAvis::where('medecin_id','=',$medecin)->where('avis_id','=',$avis->id)->first();
                $medecinAvis->delete();
            }
        }

        $avis = Avis::with(['dossier.patient.user','medecinAvis'])->whereSlug($slug)->first();

        return response()->json(['avis'=>$avis]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        $avis = Avis::with(['dossier.patient.user','medecinAvis'])->whereSlug($slug)->first();
        if (!is_null($avis))
            $avis->delete();

        return response()->json(['avis'=>$avis]);
    }
}
