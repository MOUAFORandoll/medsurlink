<?php
use App\Models\Patient;
use App\Models\ActivitesControle;
use App\Models\ActiviteAmaPatient;
use App\Models\ConsultationExamenValidation;
use App\Models\ConsultationFichier;
use App\Models\ConsultationMedecineGenerale;
use App\Models\DelaiOperation;
use App\Models\MedecinAvis;
use App\Models\Metrique;
use App\Models\PatientMedecinControle;
use App\Models\ResultatImagerie;
use App\Models\ResultatLabo;
use App\Notifications\SouscriptionAlert;
use App\User;
use Carbon\Carbon;

if(!function_exists('enregistrerCommande')) {
    function enregistrerCommande($souscripteur,$commande,$cim_id,$date_paiement)
    {
        $commande =  \App\Models\AffiliationSouscripteur::create([
            'user_id'=>$souscripteur->id,
            'type_contrat'=>$commande->name,
            'nombre_paye'=>$commande->quantity,
            'nombre_restant'=>$commande->quantity,
            'montant'=>$commande->price,
            'cim_id'=>$cim_id,
            'date_paiement'=>$date_paiement ? \Carbon\Carbon::parse($date_paiement)->toDateTimeString() : null
        ]);

        return $commande;
    }
}

if(!function_exists('reduireCommandeRestante')) {
    function reduireCommandeRestante($id, $souscripteur_id, $patient_id, $description, $affiliation_slug)
    {
        $commande =  \App\Models\AffiliationSouscripteur::where("id",$id)->first();

        $commande->nombre_restant-=1;
        $commande->save();

        $url_global = "";
        $env = strtolower(config('app.env'));
        if ($env == 'local')
            $url_global = config('app.url_loccale');
        else if ($env == 'staging')
            $url_global = config('app.url_stagging');
        else
            $url_global = config('app.url_prod');
        $souscripteur = User::where('id', $souscripteur_id)->first();
        $patient = User::where('id', $patient_id)->first();
        $nom_souscripteur = mb_strtoupper($souscripteur->nom).' '.ucfirst($souscripteur->prenom);
        $nom_patient = mb_strtoupper($patient->nom).' '.ucfirst($patient->prenom);
        $url_global = $url_global."/affiliation/".$affiliation_slug."#generale";
        $message = "Une Nouvelle Affiliation a été enregistrée pour le patient *$nom_patient* par le Souscripteur *$nom_souscripteur*.\n L'affiliation Concerne un  *$description* à *$commande->montant Euros*\n\n*Infomations du souscripteur*:\n Nom: $nom_souscripteur \nAdresse e-mail: $souscripteur->email \nTéléphone: $souscripteur->telephone \n\n *Informations du patient*:\n Nom: $nom_patient \nAdresse e-mail: $patient->email \nTéléphone: $patient->telephone \n\n<$url_global|*Cliquer ici pour plus de détails*>";
        // Send notification to affilié channel
        $commande->setSlackChannel('souscription')->notify(new SouscriptionAlert($message,null));




        return $commande;
    }
}
if(!function_exists('increaseCommandeRestante')) {
    function increaseCommandeRestante($id)
    {
        $commande =  \App\Models\AffiliationSouscripteur::where("user_id",$id)->first();

        $commande->nombre_restant+=1;
        $commande->save();

        return $commande;
    }
}
if(!function_exists('resteDeCommande')) {
    function resteDeCommande($souscripteur_id)
    {
        $commande =  \App\Models\AffiliationSouscripteur::where('user_id',$souscripteur_id)->orderBy('created_at', 'desc')->first();

        return $commande;
    }
}

if(!function_exists('peutOnAjouterCommande')) {
    function peutOnAjouterCommande($commande_id)
    {
        $commande =  \App\Models\AffiliationSouscripteur::whereId($commande_id)->first();

        return $commande->nombre_restant > 0;
    }
}

if(!function_exists('laCommandeExisteElle')) {
    function laCommandeExisteElle($commande_id)
    {
        $commande =  \App\Models\AffiliationSouscripteur::where('cim_id','==',$commande_id)->first();

        return $commande != null ;
    }
}


if(!function_exists('transformerCommande')) {
    function transformerCommande($commande,$request,$pays)
    {
        $montant = round($commande->montant / $commande->nombre_paye,2);
        $detailContrat['typeSouscription']=$commande->type_contrat ? $commande->type_contrat:'Annuelle';
        $detailContrat['typeSouscription']='Annuelle';
        $detailContrat['plaintes']=$request->plaintes;
        $detailContrat['urgence']=$request->urgence;
        $detailContrat['nom_pere']=$request->nom_pere;
        $detailContrat['nom_mere']=$request->nom_mere;
        $detailContrat['canal']=$request->canal;
        $detailContrat['dateSignature']=$commande->date_paiement;
        $detailContrat['montantSouscription']=$montant.'';
        $detailContrat['paye_par_affilie']='non';
        $detailContrat['renouvelle']='non';
        $detailContrat['decede']='non';
        $detailContrat['paysSouscription']= $pays == 'Cameroun' ? 'Cameroon' :  $pays;
        $detailContrat['date_paiement']= $commande->date_paiement;

        return $detailContrat;
    }
}

if(!function_exists('RecuperationMetrique')) {
    function RecuperationMetrique()
    {
        $patients = Patient::has('delai_operations')->get(['user_id']);
        $calcul_temps_moyen_patients = collect();

        foreach($patients as $patient){
            $delai_opeartions = DelaiOperation::where('patient_id', $patient->user_id)->latest()->get();
            $ecart_en_second = 0;
            /**
             * récupérations des délais d'opérations
             */
            foreach($delai_opeartions as $delai){
                $model = $delai->delai_operationable_type::find($delai->delai_operationable_id);
                if(!is_null($model)){
                    if($delai->delai_operationable_type == ResultatLabo::class || $delai->delai_operationable_type == ResultatImagerie::class){
                        $consultation = $model->dossier->consultationsMedecine()->latest()->first();
                        if(!is_null($consultation)){
                            $date_heure_prevue = Carbon::parse($delai->date_heure_prevue);
                            $date_heure_effectif = Carbon::parse($delai->date_heure_effectif);
                            $ecart_en_second += $date_heure_effectif->DiffInSeconds($date_heure_prevue);
                        }
                    }
                    elseif($delai->delai_operationable_type == PatientMedecinControle::class){
                        $consultation = $model->patients->dossier->consultationsMedecine()->latest()->first();
                        if(!is_null($consultation)){
                            $date_heure_prevue = Carbon::parse($delai->date_heure_prevue);
                            $date_heure_effectif = Carbon::parse($delai->date_heure_effectif);
                            $ecart_en_second += $date_heure_effectif->DiffInSeconds($date_heure_prevue);
                        }
                    }
                    elseif($delai->delai_operationable_type == ActiviteAmaPatient::class){
                        $date_heure_prevue = Carbon::parse($delai->date_heure_prevue);
                        $date_heure_effectif = Carbon::parse($delai->date_heure_effectif);
                        $ecart_en_second += $date_heure_effectif->DiffInSeconds($date_heure_prevue);
                    }
                    elseif($delai->delai_operationable_type == ConsultationFichier::class){
                        $consultation = $model->dossier->consultationsMedecine()->latest()->first();
                        if(!is_null($consultation)){
                            $date_heure_prevue = Carbon::parse($delai->date_heure_prevue);
                            $date_heure_effectif = Carbon::parse($delai->date_heure_effectif);
                            $ecart_en_second += $date_heure_effectif->DiffInSeconds($date_heure_prevue);
                        }
                    }
                    elseif($delai->delai_operationable_type == ConsultationMedecineGenerale::class){
                        $consultation = $model;
                        if(!is_null($consultation)){
                            $date_heure_prevue = Carbon::parse($delai->date_heure_prevue);
                            $date_heure_effectif = Carbon::parse($delai->date_heure_effectif);
                            $ecart_en_second += $date_heure_effectif->DiffInSeconds($date_heure_prevue);
                        }
                    }
                    elseif($delai->delai_operationable_type == MedecinAvis::class){
                        $consultation = $model->avisMedecin->dossier->consultationsMedecine()->latest()->first();
                        if(!is_null($consultation)){
                            $date_heure_prevue = Carbon::parse($delai->date_heure_prevue);
                            $date_heure_effectif = Carbon::parse($delai->date_heure_effectif);
                            $ecart_en_second += $date_heure_effectif->DiffInSeconds($date_heure_prevue);
                        }
                    }elseif($delai->delai_operationable_type == ActivitesControle::class){
                        $date_heure_prevue = Carbon::parse($delai->date_heure_prevue);
                        $date_heure_effectif = Carbon::parse($delai->date_heure_effectif);
                        $ecart_en_second += $date_heure_effectif->DiffInSeconds($date_heure_prevue);
                    }elseif($delai->delai_operationable_type == ConsultationExamenValidation::class){
                        $date_heure_prevue = Carbon::parse($delai->date_heure_prevue);
                        $date_heure_effectif = Carbon::parse($delai->date_heure_effectif);
                        $ecart_en_second += $date_heure_effectif->DiffInSeconds($date_heure_prevue);
                    }
                }
            }
            $patient->ecart_en_second = $ecart_en_second;
            $calcul_temps_moyen_patients->push($patient);
        }

        /**
         *
         * calcul des temps moyen de prise en charge par opérations
         *
         */

        $affiliation_et_affectation_medecin_referents = DelaiOperation::where('delai_operationable_type', PatientMedecinControle::class)->get();
        $affiliation_et_affectation_medecin_referents = DelaiDePriseEnChargeParOperations($affiliation_et_affectation_medecin_referents);

        $consultation_medecine_generale = DelaiOperation::where('delai_operationable_type', ConsultationMedecineGenerale::class)->get();
        $consultation_medecine_generale = DelaiDePriseEnChargeParOperations($consultation_medecine_generale);

        $consultation_fichier = DelaiOperation::where('delai_operationable_type', ConsultationFichier::class)->get();
        $consultation_fichier = DelaiDePriseEnChargeParOperations($consultation_fichier);

        $resultat_labo = DelaiOperation::where('delai_operationable_type', ResultatLabo::class)->get();
        $resultat_labo = DelaiDePriseEnChargeParOperations($resultat_labo);

        $resultat_imagerie = DelaiOperation::where('delai_operationable_type', ResultatImagerie::class)->get();
        $resultat_imagerie = DelaiDePriseEnChargeParOperations($resultat_imagerie);

        $avis_medicals = DelaiOperation::where('delai_operationable_type', MedecinAvis::class)->get();
        $avis_medicals = DelaiDePriseEnChargeParOperations($avis_medicals);

        $medecin_controle = DelaiOperation::where('delai_operationable_type', ActivitesControle::class)->get();
        $medecin_controle = DelaiDePriseEnChargeParOperations($medecin_controle);

        $consultation_examen_validation = DelaiOperation::where('delai_operationable_type', ConsultationExamenValidation::class)->get();
        $consultation_examen_validation = DelaiDePriseEnChargeParOperations($consultation_examen_validation);

        $activite_amas = DelaiOperation::where('delai_operationable_type', ActiviteAmaPatient::class)->get();
        $activite_amas = DelaiDePriseEnChargeParOperations($activite_amas);

        $temps_moyen = $calcul_temps_moyen_patients->avg('ecart_en_second');

        $date_recuperation = DelaiOperation::get()->first();
        if(!is_null($date_recuperation)){
            $date_recuperation =  $date_recuperation->created_at->format('d-M-Y');
        }else{
            $date_recuperation = Carbon::now()->format('d-M-Y');
        }
        $metrique = Metrique::whereDate('created_at', date('Y-m-d'))->first();
        if(is_null($metrique)){
            $metrique = Metrique::create([
                "temps_moyen" => $temps_moyen ?? 0,
                "affiliation_et_affectation_medecin_referents" => $affiliation_et_affectation_medecin_referents  ?? 0,
                "consultation_medecine_generale" => $consultation_medecine_generale ?? 0,
                "consultation_fichier" => $consultation_fichier ?? 0,
                "resultat_labo" => $resultat_labo ?? 0,
                "resultat_imagerie" => $resultat_imagerie ?? 0,
                "avis_medicals" => $avis_medicals ?? 0,
                "medecin_controle" => $medecin_controle ?? 0,
                "consultation_examen_validation" => $consultation_examen_validation ?? 0,
                "activite_amas" => $activite_amas ?? 0,
                "nbre_patients" => $calcul_temps_moyen_patients->count() ?? 0
            ]);
        }else{
            $metrique->update(
                [
                    "temps_moyen" => $temps_moyen ?? 0,
                    "affiliation_et_affectation_medecin_referents" => $affiliation_et_affectation_medecin_referents  ?? 0,
                    "consultation_medecine_generale" => $consultation_medecine_generale ?? 0,
                    "consultation_fichier" => $consultation_fichier ?? 0,
                    "resultat_labo" => $resultat_labo ?? 0,
                    "resultat_imagerie" => $resultat_imagerie ?? 0,
                    "avis_medicals" => $avis_medicals ?? 0,
                    "medecin_controle" => $medecin_controle ?? 0,
                    "consultation_examen_validation" => $consultation_examen_validation ?? 0,
                    "activite_amas" => $activite_amas ?? 0,
                    "nbre_patients" => $calcul_temps_moyen_patients->count() ?? 0
                ]
            );
        }
        $metrique->date_recuperation = $date_recuperation;
        return $metrique;
    }
}
