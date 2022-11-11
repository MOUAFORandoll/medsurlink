<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\PersonnalErrors;
use App\Http\Requests\AffiliationRequest;
use App\Models\Affiliation;
use App\Models\LigneDeTemps;
use App\Models\Motif;
use App\Models\Patient;
use App\Models\PatientSouscripteur;
use App\Models\AffiliationSouscripteur;
use App\Models\PaymentOffre;
use App\Models\CommandePackage;
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
    public function index(Request $request)
    {
        if($request->sortCIM == 7 || $request->sortCIM == 14 || $request->sortCIM == 30){
            $affiliations = Affiliation::has('patient.user')->whereDateBetween('date_fin', Carbon::now()->format('Y-m-d'), Carbon::now()->addDays($request->sortCIM)->format('Y-m-d'))->with(['patient','patient.dossier','package','patient.financeurs.lien'])->orderBy('date_fin', 'desc')->get();
        }elseif($request->sortCIM == ""){
            $affiliations = Affiliation::has('patient.user')->with(['patient','patient.dossier','package','patient.financeurs.lien'])->orderBy('date_fin', 'desc')->get();
        }else{
            $affiliations = Affiliation::has('patient.user')->whereDate('date_fin', '<', Carbon::now()->format('Y-m-d'))->with(['patient','patient.dossier','package','patient.financeurs.lien'])->orderBy('date_fin', 'desc')->get();
        }
       
        foreach ($affiliations as $affiliation){
            if(is_null($affiliation->cloture)){
                $affiliation->cloture()->create([]);
            }
            if (!is_null($affiliation->patient)){
                $affiliation['user'] = isset($affiliation->patient->user) ? $affiliation->patient->user : null ;
                $affiliation['souscripteur'] = isset($affiliation->patient->souscripteur->user) ? $affiliation->patient->souscripteur->user  : null;
            }
        }
        return response()->json(['affiliations' => $affiliations]);
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
        /*$this->Affiliated($request);

        $patient = Patient::where('user_id', $request->patient_id)->first();
        if($patient){
            $affiliation = Affiliation::create([
                "patient_id"=> $request->patient_id,
                "souscripteur_id"=>$request->souscripteur_id,
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
                // 'personne_contact' => $request->personne_contact,
                'paye_par_affilie' => $request->paye_par_affilie,
                'selected' => $request->selected,
                "nombre_envois_email"=>0,
                "expire_email"=>0,
                "nom"=>'Annuelle',
                "date_debut"=>  $request->date_debut ?? Carbon::now(),
                "date_fin"=>Carbon::now()->addYears(1)->format('Y-m-d')
            ]);
            $patient->souscripteur_id = $request->souscripteur_id;
            $patient->save();

            // Ajout du souscripteur à la liste des souscripteurs du patient
            PatientSouscripteur::create([
                'financable_type'=>'Souscripteur',
                'financable_id'=> $request->souscripteur_id,
                'patient_id'=> $request->patient_id,
                'lien_de_parente' => $request->lien
            ]);
            //reduction du nombre de commande du Souscripteur
            $package_id = $request->package_id;
            $commande =  AffiliationSouscripteur::whereHas('commande.paymentOffres', function($query) use ($package_id){
                $query->where(['status' => 'SUCCESS', 'offres_packages_id' => $package_id]);
            })->where(['user_id' => $request->souscripteur_id])->first();

            if(is_null($commande)){
                $souscription =  CommandePackage::create([
                    "date_commande" => Carbon::now()->toDateTimeString(),
                    'quantite' =>1,
                    'offres_packages_id' =>$request->get('package_id'),
                    'souscripteur_id' => $request->souscripteur_id,
                ]);
                $package = $souscription->offres_package;
                PaymentOffre::create([
                    "date_payment" => Carbon::now()->toDateTimeString(),
                    "montant" => 1 * $package->montant,
                    'status' => 'SUCCESS',
                    'commande_id' =>$souscription->id,
                    'souscripteur_id' => $request->souscripteur_id,
                ]);
                $commande = AffiliationSouscripteur::create([
                    'user_id'=> $request->souscripteur_id,
                    'nombre_paye'=> 1,
                    'nombre_restant'=> 1,
                    'montant' => $package->montant,
                    'cim_id'=>$request->package_id,
                    'date_paiement'=>null,
                   ]);
            }
            \Log::alert($request);
            $commande = reduireCommandeRestante($commande->id);


            if($request->plaintes){
                $all_plaintes = explode(",", $request->plaintes);
                $plaintes = [];
                foreach($all_plaintes as $plainte){
                    if(str_contains($plainte, 'item_')){
                        /**
                         * on créé une nouvelle plainte si elle n'existe pas
                         */
                        /*$motif = Motif::where(["description" => explode("item_", $plainte)[1]])->first();
                        if(is_null($motif)){
                            $motif = Motif::create(["reference" => now(), "description" => explode("item_", $plainte)[1]]);
                            defineAsAuthor("Motif",$motif->id,'create');
                        }
                        $plaintes[] = $motif->id;
                    }else{
                        $plaintes[] = $plainte;
                    }
                }

                $affiliation->motifs()->sync($plaintes);
                $affiliation->cloture()->create([]);
                /**
                 * creation d'une ligne de temps après une affiliation
                */
                /*$ligne_temps = LigneDeTemps::create(['dossier_medical_id' => $affiliation->patient->dossier->id, 'motif_consultation_id' => $plaintes[0], 'etat' => 1, 'date_consultation' => date('Y-m-d'), 'affiliation_id' => $affiliation->id]);
                $ligne_temps->motifs()->sync($plaintes);
            }

            return response()->json(['affiliation' => $affiliation]);
        }else{
            return response()->json(['erreur' => "Le patient n'existe pas"], 419);
        }*/
       return AjoutDuneAffiliation($request);
    }


    /**
     * @param $slug
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function show($slug)
    {
        $this->validatedSlug($slug,$this->table);
        $affiliation = Affiliation::with(['patient', 'motifs:id,description', 'patient.dossier', 'package:id,description_fr,montant', 'patient.financeurs.lien'])->whereSlug($slug)->first();
        if(is_null($affiliation->cloture)){
            $affiliation->cloture()->create([]);
        }

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
        //$affiliation->clotures = $affiliation->cloture->first();
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
    public function edit(Request $request, $slug)
    {
        $this->validatedSlug($slug,$this->table);

        $this->Affiliated($request);

        // Affiliation::whereSlug($slug)->update($request->validated());

        // $affiliation = Affiliation::with(['patient'])->whereSlug($slug)->first();
        $affiliation = Affiliation::with(['motifs:id,description', 'patient.dossier:id,numero_dossier,slug', 'package:id,description_fr,montant', 'patient.financeurs.lien'])->whereSlug($slug)->first();

        $this->updateDateFin($affiliation);

        return response()->json(['affiliation' => $affiliation]);
    }


    /**
     * @param AffiliationRequest $request
     * @param $slug
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\PersonnnalException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, $slug)
    {
        // $this->Affiliated($request);
        // $this->validatedSlug($slug,$this->table);
        $patient = Patient::where('user_id', $request->patient_id)->first();

        if($patient){
            $affiliation = Affiliation::where('slug',$slug)->first();

            // modification du souscripteur à la liste des souscripteurs du patient
            $patientsouscripteur = PatientSouscripteur::where(['financable_type' => 'Souscripteur', 'financable_id' => $patient->souscripteur_id, 'patient_id' => $affiliation->patient_id])->first();
            $patientsouscripteur->update([
                'financable_type'=>'Souscripteur',
                'financable_id'=> $request->souscripteur_id,
                'patient_id'=> $request->patient_id,
                'lien_de_parente' => $request->lien
            ]);

            $affiliation->patient_id =  $request->patient_id;
            $affiliation->souscripteur_id  = $request->souscripteur_id ;
            $affiliation->package_id = $request->package_id;
            $affiliation->date_signature = Carbon::now();
            $affiliation->status_contrat = $request->status_contrat;
            $affiliation->status_paiement =  $request->status_paiement;
            $affiliation->renouvelle = 0;
            $affiliation->expire = 0;
            $affiliation->code_contrat = $patient->dossier->numero_dossier;
            $affiliation->niveau_urgence = $request->niveau_urgence;
            $affiliation->plainte =  $request->plainte;
            $affiliation->contact_firstName =  $request->contact_firstName;
            $affiliation->contact_name =  $request->contact_name;
            $affiliation->contact_phone =  $request->contact_phone;
            $affiliation->selected =  $request->selected;
        //    $affiliation->personne_contact = $request->personne_contact;
            $affiliation->paye_par_affilie =  $request->paye_par_affilie;
            $affiliation->nombre_envois_email = 0;
            $affiliation->expire_email = 0;
            $affiliation->nom = 'Annuelle';
            $affiliation->date_debut = $request->date_debut ?? Carbon::now();
            $affiliation->date_fin = Carbon::now()->addYears(1)->format('Y-m-d');

            $patient->souscripteur_id = $request->souscripteur_id;
            $affiliation->save();
            $patient->save();


            if($request->plaintes){
                $all_plaintes = explode(",", $request->plaintes);
                $plaintes = [];
                foreach($all_plaintes as $plainte){
                    if(str_contains($plainte, 'item_')){
                        /**
                         * on créé une nouvelle plainte si elle n'existe pas
                         */
                        $motif = Motif::where(["description" => explode("item_", $plainte)[1]])->first();
                        if(is_null($motif)){
                            $motif = Motif::create(["reference" => now(), "description" => explode("item_", $plainte)[1]]);
                            defineAsAuthor("Motif",$motif->id,'create');
                        }
                        $plaintes[] = $motif->id;
                    }else{
                        $plaintes[] = $plainte;
                    }
                }
                if(count($plaintes) > 0){
                    $affiliation->motifs()->detach();
                    $affiliation->motifs()->sync($plaintes);
                    /**
                     * creation d'une ligne de temps après une affiliation
                    */
                    $ligne_temps = $affiliation->ligneTemps()->first();
                    if($ligne_temps){
                        $ligne_temps->update(['dossier_medical_id' => $affiliation->patient->dossier->id, 'motif_consultation_id' => $plaintes[0], 'etat' => 1, 'date_consultation' => date('Y-m-d'), 'affiliation_id' => $affiliation->id]);
                        $ligne_temps->motifs()->detach();
                        $ligne_temps->motifs()->sync($plaintes);
                    }else{
                        $ligne_temps = LigneDeTemps::create(['dossier_medical_id' => $affiliation->patient->dossier->id, 'motif_consultation_id' => $plaintes[0], 'etat' => 1, 'date_consultation' => date('Y-m-d'), 'affiliation_id' => $affiliation->id]);
                        $ligne_temps->motifs()->sync($plaintes);
                    }
                }
            }


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



    // public function stateSuspend($id)
    // {
    //     $affiliation = affiliation::whereId($id)->first();

    //     if ($affiliation != null){
    //         $affiliation->suspendu = $affiliation->suspendu== 1 ? 0 : 1;
    //         $affiliation->save();
    //         return response()->json(["affiliation" => $affiliation]);
    //     }
    // }


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

    public function getLastestAffiliation(){
        $affiliations = Affiliation::has('patient.user')->with(['patient.dossier','patient.user','package'])->whereHas('package', function($query){
            $query->where('id', 1)->OrWhere('id', 2);
        })->latest()->take(10)->get();
        return response()->json($affiliations);
    }
}
