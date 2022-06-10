<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Traits\PersonnalErrors;
use App\Http\Requests\ActiviteRequest;
use App\Models\Activite;
use App\Models\ActivitesAma;
use App\Models\ActiviteMission;
use App\Models\ActiviteAmaPatient;
use App\Models\PatientMedecinControle;
use App\Models\GroupeActivite;
use Carbon\Carbon;
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
        $activites = Activite::with('createur','groupe')->latest()->get();
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
        $activite = Activite::create(['groupe_id'=>$request->get('groupe_activite')]+$request->only('date_cloture','statut'));
        $missions = $request->get('missions');

        foreach ($missions as $mission){
            ActiviteMission::create(['activite_id'=>$activite->id]+$mission);
        }

        $activite = Activite::with('missions.description','createur','groupe')->whereId($activite->id)->first();

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

        $activite = Activite::with([
                'missions.description',
                'createur',
                'groupe',
                'missions.dossier.patient.user',
                'missions.createur']
        )->whereSlug($slug)->first();

        return response()->json(['activite'=>$activite]);
    }

    public function showGroupActivities($slug){
        $this->validatedSlug($slug,'groupe_activites');
        $groupe = GroupeActivite::whereSlug($slug)->first();
        $activites = Activite::with([
            'missions.description',
            'createur',
            'groupe',
            'missions.createur',
            'missions.dossier.patient.user'
        ])->where('groupe_id',$groupe->id)->latest()->latest()->get();
        return response()->json(['activites'=>$activites]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $slug)
    {
        $this->validatedSlug($slug,$this->table);

        Activite::whereSlug($slug)->update($request->all());

        $activite = Activite::with([
            'missions.description',
            'createur',
            'groupe',
            'missions.createur',
            'missions.dossier.patient.user'
        ])->whereSlug($slug)->first();

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

        $activite = Activite::with([
                'missions.description',
                'createur',
                'groupe',
                'missions.dossier.patient.user',
                'missions.createur']
        )->whereSlug($slug)->first();

        $activite->delete();

        return response()->json(['activite'=>$activite]);
    }

    public function cloturer($slug){
        $this->validatedSlug($slug,$this->table);

        $activite = Activite::with([
                'missions.description',
                'createur',
                'groupe',
                'missions.dossier.patient.user',
                'missions.createur']
        )->whereSlug($slug)->first();

        $activite->statut=true;
        $activite->date_cloture = Carbon::now()->format('Y-m-d');
        $activite->save();

        return response()->json(['activite'=>$activite]);
    }

    public function updateActiviteMission(Request $request,$missionSlug){
        $this->validatedSlug($missionSlug,'activite_missions');

        $mission = ActiviteMission::whereSlug($missionSlug)->update($request->all());

        $mission = ActiviteMission::with('description','dossier.patient.user','createur')->whereSlug($missionSlug)->first();

        return response()->json(['mission'=>$mission]);
    }

    public function ajouterMission(Request $request){
        $mission = ActiviteMission::create($request->all());
        $mission = ActiviteMission::with('dossier.patient.user','createur')->whereSlug($mission->slug)->first();
        return response()->json(['mission'=>$mission]);
    }

    public function getMissionAma($id){
        $mission = ActiviteAmaPatient::with(['activitesAma','patient','updatedBy','createur'])->latest()->get();
        return response()->json(['activites'=>$mission]);
    }
    public function getMissionAmaByPatient($id){
        $mission = ActiviteAmaPatient::with(['activitesAma','patient','updatedBy','createur'])->where('patient_id',$id)->latest()->get();
        $medecin_referent = PatientMedecinControle::with(['medecinControles','patients','createur'])->where('patient_id',$id)->latest()->get();
        return response()->json(['activites'=>$mission, 'referent'=>$medecin_referent]);
    }
    public function saveMissions(Request $request){
        dd($request);
        //$mission = ActiviteAmaPatient::with(['activitesAma','patient','updatedBy','createur'])->latest()->get();
       // return response()->json(['activites'=>$mission]);
    }
    public function createMissions(Request $request){

        // $mission = ActiviteAmaPatient::create($request->all());
        $activities = $request->get('activities');
        $request->validate([
            'activities' => 'required',
        ]);
        foreach($activities as $activity){
            foreach($activity['selected'] as $selectId){
                ActiviteAmaPatient::create([
                    'activite_ama_id' => $selectId,
                    'date_cloture' => $activity['date_cloture_activite'],
                    'affiliation_id' => $request->get('affiliation_id'),
                    'commentaire' => $request->get('commentaire'),
                    'ligne_temps_id' => $request->get('ligne_temps_id'),
                    'patient_id' => $request->get('patient_id'),
                    'etablissement_id' => $request->get('etablissement_id'),
                    'statut' => $request->get('statut'),
                ]);
            }

        }
        return  response()->json(['statut'=>true]);
        // foreach($activities as $activity){
        //     //dd($examen);
        //     ActiviteAmaPatient::create([
        //         'date_cloture_activite' =>$activity->get('etablissement_id'),
        //         'selected' => $activity['selected'],
        //         'affiliation_id' => $request->get('affiliation_id'),
        //         'commentaire' => $request->get('commentaire'),
        //         'etablissement_id' => $request->get('etablissement_id'),
        //         'ligne_temps_id' => $request->get('ligne_temps_id'),
        //         'ligne_temps_id' => $request->get('ligne_temps_id'),
        //     ]);
        // }
        // $mission = ActiviteAmaPatient::with('activitesAma','patient','updatedBy','createur')->whereSlug($mission->slug)->first();
        // return response()->json(['mission'=>$mission]);
    }
    public function getListMission(){
        $mission = ActivitesAma::where('type','MANUELLE')->get();
        return response()->json(['activites'=>$mission]);
    }
    public function supprimerMission($slug){
        $this->validatedSlug($slug,'activite_missions');
        $mission = ActiviteMission::with('description','dossier.patient.user','createur')->whereSlug($slug)->first();
        $mission->delete();
        return response()->json(['mission'=>$mission]);
    }

}
