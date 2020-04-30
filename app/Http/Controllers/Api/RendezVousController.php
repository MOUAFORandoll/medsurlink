<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Traits\PersonnalErrors;
use App\Http\Requests\RendezVousRequest;
use App\Models\RendezVous;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;

class RendezVousController extends Controller
{
    use PersonnalErrors;
    protected $table = 'rendez_vous';
    /**
     * Display a listing of the resource.
     * Retourne les rdv dans l'intervale [$nbre de mois avant $dateDebut, $nbre de mois apres $dateDebut]
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $dateDebut = $request->get('date_debut');
        $nbre = $request->get('nbre',1);
        $userId = 77;

        try {
            $dateDebut = Carbon::parse($dateDebut);
        }catch (\Exception $exception){
            $dateDebut = Carbon::now();
        }
        //On récupère les rendez entre ces deux dates

        $dateAvant = date('Y-m-d', strtotime($dateDebut. ' - '.$nbre.' months'));
        $dateApres = date('Y-m-d', strtotime($dateDebut. ' + '.$nbre.' months'));



        $rdvs = RendezVous::with(['patient','praticien','sourceable','initiateur'])
            ->where('praticien_id','=',$userId)
            ->orWhere('patient_id','=',$userId)
            ->orWhere('initiateur','=',$userId)
            ->get();

        $rdvsAvant = $rdvs->where('date','>=',$dateAvant)
            ->all();

        $rdvsApres = $rdvs->where('date','>=',$dateApres)
            ->all();

        $rdvs = $rdvsAvant+$rdvsApres;

        return response()->json(['rdvs'=>$rdvs]);
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
    public function store(RendezVousRequest $request)
    {
//        //Auth::loginUsingId(77);
        $rdv = RendezVous::create($request->all()+['initiateur'=>Auth::id()]);

        defineAsAuthor("RendezVous", $rdv->id, 'create');

        return response()->json(['rdv'=>$rdv]);
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

        $rdv = RendezVous::with(['patient','praticien','sourceable','initiateur'])
            ->whereSlug($slug)
            ->first();

        return response()->json(['rdv'=>$rdv]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        $this->validatedSlug($slug,$this->table);

        $rdv = RendezVous::findBySlugOrFail($slug);

        return response()->json(['rdv'=>$rdv]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function update(RendezVousRequest $request, $slug)
    {

        $this->validatedSlug($slug,$this->table);

        RendezVous::whereSlug($slug)->update($request->all());

        $rdv = RendezVous::with(['patient','praticien','sourceable','initiateur'])
            ->WhereSlug($slug)
            ->first();

        defineAsAuthor("RendezVous", $rdv->id, 'update');

        return response()->json(['rdv'=>$rdv]);
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

        $rdv = RendezVous::findBySlugOrFail($slug);
        $rdv->delete();

        defineAsAuthor("RendezVous", $rdv->id, 'delete');

        return  response()->json(['rdv'=>$rdv]);
    }
}
