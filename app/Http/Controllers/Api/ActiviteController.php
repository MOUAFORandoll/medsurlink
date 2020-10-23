<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Traits\PersonnalErrors;
use App\Http\Requests\ActiviteRequest;
use App\Models\Activite;
use App\Models\ActiviteMission;
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
        $activites = Activite::all();
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
        $activite = Activite::create(['groupe_id'=>$request->get('groupe_activite')],$request->only('date_cloture','statut'));
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
        ])->where('groupe_id',$groupe->id)->get();
        return response()->json(['activites'=>$activites]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function update(ActiviteRequest $request, $slug)
    {
        $this->validatedSlug($slug,$this->table);

        Activite::whereSlug($slug)->update($request->except('activite'));

        $activite = Activite::whereSlug($slug)->first();

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
}
