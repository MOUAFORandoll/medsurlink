<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\PersonnalErrors;
use App\Http\Requests\AffiliationRequest;
use App\Models\Affiliation;
use App\Models\Patient;
use App\Models\PatientSouscripteur;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AffiliationController extends Controller
{
    use PersonnalErrors;
    protected $table = 'affiliations';



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $affiliations = Affiliation::has('patient.user')->with(['patient','patient.dossier','package','patient.financeurs.lien'])->latest()->get();
        foreach ($affiliations as $affiliation){
            if (!is_null($affiliation->patient)){
                $affiliation['user'] = $affiliation->patient->user;
                $affiliation['souscripteur'] = $affiliation->patient->souscripteur->user;
            }
        }
        return response()->json(['affiliations'=>$affiliations]);
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
     * @param AffiliationRequest $request
     * @return \Illuminate\Http\Response
     * @throws \App\Exceptions\PersonnnalException
     */
    public function store(AffiliationRequest $request)
    {
        $this->Affiliated($request);

        $patient = Patient::where('user_id', $request->patient_id)->first();
        if($patient){
            $affiliation = Affiliation::create([
                "patient_id"=> $request->patient_id,
                "souscripteur_id"=>$request->soucripteur_id,
                "package_id"=>$request->package_id,
                "date_signature"=>Carbon::now(),
                "status_contrat"=> $request->status_contrat,
                "status_paiement"=> $request->status_paiement,
                "renouvelle"=>0,
                "expire"=>0,
                "code_contrat"=>$patient->dossier->numero_dossier,
                "niveau_urgence"=>$request->niveau_urgence,
                "plainte" => $request->plainte,
                "contact_firstName" => $request->contact_firstName,
                "contact_name" => $request->contact_name,
                "contact_phone" => $request->contact_phone,
                'personne_contact' => $request->personne_contact,
                'paye_par_affilie' => $request->paye_par_affilie,
                "nombre_envois_email"=>0,
                "expire_email"=>0,
                "nom"=>'Annuelle',
                "date_debut"=>Carbon::now(),
                "date_fin"=>Carbon::now()->addYears(1)->format('Y-m-d')
            ]);
            $patient->souscripteur_id = $request->soucripteur_id;
            $patient->save();

            // Ajout du souscripteur à la liste des souscripteurs du patient
            PatientSouscripteur::create([
                'financable_type'=>'Souscripteur',
                'financable_id'=> $request->soucripteur_id,
                'patient_id'=> $request->patient_id,
                'lien_de_parente' => $request->lien
            ]);

            return response()->json(['affiliation'=>$affiliation]);
        }else{
            return response()->json(['erreur'=> "Le patient n'existe pas"], 419);
        }


    }


    /**
     * @param $slug
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function show($slug)
    {
        $this->validatedSlug($slug,$this->table);
        $affiliation = Affiliation::with(['patient','patient.dossier','package','patient.financeurs.lien'])->whereSlug($slug)->first();

        $date_fin = Carbon::createFromFormat('Y-m-d', $affiliation->date_fin);
        $today = Carbon::createFromFormat('Y-m-d', date('Y-m-d'));

        if($today->gt($date_fin) && ($affiliation->status_contrat != 'Résilié')){
            $affiliation->status_contrat = 'Expiré';
            $affiliation->expire = 1;

        }elseif($date_fin->gte($today) && ($affiliation->status_contrat != 'Résilié')){
            if($affiliation->status_contrat == 'Généré' && $affiliation->status_paiement == 'PAYE'){
                $affiliation->status_contrat = 'Actif';
            }elseif(($affiliation->status_contrat == 'Généré' && $affiliation->status_paiement == 'NON PAYE')){
                $affiliation->status_contrat = 'Généré';
            }
            if($affiliation->renouvelle){
                $affiliation->status_contrat = 'Renouvélé';
            }
            $affiliation->expire = 0;
        }
        $affiliation->save();

        if (!is_null($affiliation->patient)) {
            $affiliation['user'] = $affiliation->patient->user;
            $affiliation['souscripteur'] = $affiliation->patient->souscripteur->user;
        }
        //if($affiliation->status_contrat )
        return response()->json(['affiliation'=>$affiliation]);
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
     * @param AffiliationRequest $request
     * @param $slug
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\PersonnnalException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(AffiliationRequest $request, $slug)
    {

        $this->validatedSlug($slug,$this->table);

        $this->Affiliated($request);

        Affiliation::whereSlug($slug)->update($request->validated());

        $affiliation = Affiliation::with(['patient'])->whereSlug($slug)->first();

        $this->updateDateFin($affiliation);

        return response()->json(['affiliation' => $affiliation]);

    }


    /**
     * @param $slug
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function destroy($slug)
    {
        $this->validatedSlug($slug,$this->table);

        $affiliation = Affiliation::with(['patient'])->whereSlug($slug)->first();
        $affiliation->delete();

        return response()->json(['affiliation'=>$affiliation]);
    }

    /**
     * @param Affiliation $affiliation
     */
    public function updateDateFin(Affiliation $affiliation){
        $date_debut = $affiliation->date_debut;

        if ($affiliation->nom == 'One shot'){
            $date_fin = $date_debut;

        }elseif ($affiliation->nom == 'Annuelle'){
            $date_fin = Carbon::parse($date_debut)->addYears(1)->format('Y-m-d');
        }

        $affiliation->date_fin = $date_fin;
        $affiliation->save();
    }
    public function updateStatus(Request $request){
        $affiliation =  Affiliation::where('id','=',$request->id)->first();
        $affiliation->status_contrat = $request->status;
        $affiliation->save();
    }
    /**
     * Permet de determiner si un utilisateur possede deja une affiliation
     * @param Request $request
     * @throws \App\Exceptions\PersonnnalException
     */
    public function affiliateBySouscripteur($souscripteur)
    {
        $affiliations = Affiliation::has('patient.user')->with(['patient.dossier', 'patient.user', 'package','patient.financeurs.lien','souscripteur'])->where("souscripteur_id",$souscripteur)->latest()->get();
       /*  foreach ($affiliations as $affiliation){
            if (!is_null($affiliation->patient)){
                //dd($affiliation->patient->user);
                $affiliation['user'] = $affiliation->user;
                $affiliation['souscripteur'] = $affiliation->souscripteur->user;
            }
        } */
        return response()->json($affiliations);
    }
    public function Affiliated(Request $request){
        $date_debut = Carbon::parse($request->date_debut)->year;

        //Ici on determine si le patient a deja une affiliation pour cette année
        $affiliation =  Affiliation::where('patient_id','=',$request->patient_id)->where('package_id', $request->package_id)->where('nom','=','Annuelle')->WhereYear('date_debut',$date_debut)->latest()->get();

        if (count($affiliation)>0) {
            $msg = $affiliation[0]->package;
            $message = "Le patient dispose déjà de la même affiliation pour cette année ({$msg->description_fr})";
            $this->revealError('dejaAffilie',$message);

        } elseif ($request->nom == "One shot"){
            //On determine si le patient a deja une affiliation oneshot a ce jour
            $date_debut = $request->date_debut;

            if (is_null($request->date_fin)){
                $date_fin = Carbon::now()->format('Y-m-d');

            }else{
                $date_fin = $request->date_fin;

                if ($date_fin != $date_debut){
                    $message = "L'affiliation One shot se fait en un seul jour";
                    $this->revealError('dejaAffilie',$message);
                }
            }

            if ($date_fin == $date_debut){
                $affiliation =  Affiliation::where('patient_id','=',$request->patient_id)->where('package_id', $request->package_id)->where('nom','=','One shot')->whereDate('date_debut',$date_debut)->whereDate('date_fin',$date_fin)->latest()->get();
                if (count($affiliation)>0){
                    $msg = $affiliation[0]->package;
                    $message = "Le patient dispose déjà de la même affiliation pour ce jour {$msg->description_fr})";
                    $this->revealError('dejaAffilie',$message);
                }
            }
        }
    }
}
