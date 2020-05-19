<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\PersonnalErrors;
use App\Http\Requests\RendezVousRequest;
use App\Models\RendezVous;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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
        $userId = Auth::id();

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

        //Ici on récupère les rendez vous des autres praticiens et médécin
        $user = Auth::user();
        $roleName = $user->getRoleNames()->first();
        if ($roleName == 'Praticien' || $roleName == 'Medecin controle' || $roleName == 'Admin'){
            if (strpos('medicasure.com',$user->email)){
                $rdvDesAutres = RendezVous::with(['patient','praticien','sourceable','initiateur'])
                    ->where('praticien_id','<>',$userId)
                    ->get();

                $rdvsApres = $rdvsApres + $rdvDesAutres->where('date','>=',$dateApres)->all();
                $rdvsAvant = $rdvsAvant + $rdvDesAutres->where('date','>=',$dateAvant)->all();
            }
        }
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
//        Auth::loginUsingId(77);
        //Récupération du nom du medecin ou bien de l'identifiant du praticien
        $praticien = $request->get('praticien_id');

        $praticienId = (integer) $praticien;

        if ($praticienId !== 0){
            $validator = Validator::make(['praticien_id'=>$praticienId],['praticien_id'=>'required|integer|exists:users,id']);

            if($validator->fails()){
                return $this->revealError('praticien_id','le praticien spécifié n\'exite pas dans la bd');
            }else{
                $rdv = RendezVous::create($request->except('praticien_id') + ['praticien_id'=>$praticienId,'initiateur'=>Auth::id()]);
            }
        }else{

            if ($praticien != ""){

                $rdv = RendezVous::create($request->except('praticien_id') + ['nom_medecin'=>$praticien,'initiateur'=>Auth::id()]);
            }
        }

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

        //Récupération du nom du medecin ou bien de l'identifiant du praticien
        $praticien = $request->get('praticien_id');

        $praticienId = (integer) $praticien;

        if ($praticienId !== 0){
            RendezVous::whereSlug($slug)->update($request->except('praticien_id') + ['praticien_id'=>$praticienId,'initiateur'=>Auth::id()]);
        }else{
            if ($praticien != ""){
                RendezVous::whereSlug($slug)->update($request->except('praticien_id') + ['nom_medecin'=>$praticien,'initiateur'=>Auth::id()]);
            }
        }


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
