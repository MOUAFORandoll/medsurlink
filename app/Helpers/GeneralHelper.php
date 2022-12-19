<?php
use App\SMS;
use App\User;
use Carbon\Carbon;
use Psy\Util\Json;
use App\Models\Motif;
use GuzzleHttp\Client;
use App\Models\Package;
use App\Models\Patient;
use App\Models\Praticien;
use App\Mail\OrderShipped;
use Carbon\CarbonInterval;
use App\Models\Affiliation;
use Illuminate\Support\Arr;
use App\Models\LigneDeTemps;
use App\Models\PaymentOffre;
use App\Models\Souscripteur;
use App\Models\TimeActivite;
use Illuminate\Http\Request;
use App\Models\ReponseSecrete;
use App\Notifications\SendSMS;
use App\Mail\NouvelAffiliation;
use App\Models\CommandePackage;
use App\Models\MedecinControle;
use App\Mail\Facture\AchatOffre;
use Barryvdh\DomPDF\Facade as PDF;
use App\Models\PatientSouscripteur;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Models\AffiliationSouscripteur;
use App\Mail\Facture\PaiementPrestation;
use App\Notifications\SouscriptionAlert;
use App\Http\Requests\AffiliationRequest;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Validator;
use App\Models\ConsultationMedecineGenerale;
use App\Http\Controllers\Traits\PersonnalErrors;

if(!function_exists('sendSMS'))
{
    /**
     * Send a SMS to a number
     *
     * @param $telephone
     * @param $message
     * @param $sender
     */
    function sendSMS($telephone, $message, $sender = null) {
        // To not to trigger an error while sending the message, check if the telephone is well formatted

        $response = formatTelephone($telephone);

        if(!is_null($response)) {
            $sms = new SMS();
            $sms->telephone = $response;
            $sms->notify(new SendSMS($message, getFullNameWithoutAccent( is_null($sender) ? 'MEDSURLINK' : $sender)));
        }

        // TODO: Perform otherwise action
    }
}

if(!function_exists('sendSmsToUser'))
{
    /**
     * Send a SMS to a User
     *
     * @param $user
     * @param null $sender
     */
    function sendSmsToUser($user,$sender = null) {
        if (!is_null($user)){
            if ($user->decede == 'non'){
                try {
                    $nom = (is_null($user->prenom) ? "" : ucfirst($user->prenom) ." ") . "". strtoupper( $user->nom);
                    sendSMS($user->telephone,trans('sms.accountUpdated',['nom'=>$nom],'fr'),$sender);
                }catch (\Exception $exception){
                    //$exception
                }
            }
        }
    }
}
if(!function_exists('_group_by'))
{
    /**
     * Group array by key
     *
     * @param $array
     * @param $key
     */
    function _group_by($array, $key) {
        $return = array();
        foreach($array as $val) {
            $return[$val[$key]][] = $val;
        }
        return $return;
    }
}
if(!function_exists('isJSON'))
{
    function isJSON($string){
        return is_string($string) && is_array(json_decode($string, true)) && (json_last_error() == JSON_ERROR_NONE) ? true : false;
    }
}
if(!function_exists('getFullNameWithoutAccent'))
{
    /**
     * @param $string_with_accent
     * @return string
     */
    function getFullNameWithoutAccent($string_with_accent)
    {
        $search  = array('À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'à', 'á', 'â', 'ã', 'ä', 'å', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ð', 'ò', 'ó', 'ô', 'õ', 'ö', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ');
        //Préférez str_replace à strtr car strtr travaille directement sur les octets, ce qui pose problème en UTF-8
        $replace = array('A', 'A', 'A', 'A', 'A', 'A', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y', 'a', 'a', 'a', 'a', 'a', 'a', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y');

        $string_without_accent = str_replace($search, $replace, $string_with_accent);
        return $string_without_accent;
    }
}

if(!function_exists('mapExpectValue'))
{
    /**
     * @param $string_with_accent
     * @return string
     */
    function mapExpectValue($arrayList,$unNeedArray)
    {
      return Arr::except($arrayList,$unNeedArray);
    }
}

if(!function_exists('formatTelephone'))
{
    function formatTelephone($telephone) {

        // convert the string to an array
        $arr = str_split($telephone);


        // Remove everything except numbers
        $newArr = array_filter($arr, function ($item) {
            return preg_match("/[0-9]/i", $item);
        });

        // Parse to string
        $response = join($newArr);

        // remove the international calling prefix
        if(substr($response, 0, 2) == '00') {
            $response = substr($response, 2, strlen($response));
        }
        else if(substr($response, 0, 3) == '011') {
            $response = substr($response, 3, strlen($response));
        }

        // remove the country code
        // Cameroon
        if(substr($response, 0, 3) == '237') {
            $response = substr($response, 3, strlen($response));
        }

        // Belgium
        else if(substr($response, 0, 2) == '32') {
            $response = substr($response, 2, strlen($response));
        }


        // Cameroon pattern 6x xx xx xx xx
        if(strlen($response) == 8) {
            return '2376' . $response;
        }

        // Cameroon pattern 6x xx xx xx xx
        else if(strlen($response) == 9 && $response[0] == '6') {
            return '237' . $response;
        }

        // belgium pattern xx xx xx xx xx
        else if(strlen($response) == 10 || strlen($response) == 9) {
            return '32' . $response;
        }

        // Incorrect number
        return null;
    }
}




    if(!function_exists('EnvoieDeFactureApresSouscription'))
{
    /**
     * @param $string_with_accent
     * @return string
     */
    function EnvoieDeFactureApresSouscription($commande_id, $commande_date, $montant_total, $echeance, $description, $quantite, $prix_unitaire, $nom_souscripteur, $email_souscripteur, $rue, $adresse, $ville, $pays, $beneficiaire)
    {
        //return view('impression_offre');
        try {
            $pdf = generationPdfFactureOffre($commande_id, $commande_date, $montant_total, $echeance, $description, $quantite, $prix_unitaire, $nom_souscripteur, $email_souscripteur, $rue, $adresse, $ville, $pays, $beneficiaire);
            Mail::to($email_souscripteur)->cc("contrat@medicasure.com")->send(new AchatOffre($pdf['output'], $nom_souscripteur, $description));
        }catch (\Exception $exception){
            //$exception
        }
    }
}
if(!function_exists('generationPdfFactureOffre'))
{
    /**
     * @param $string_with_accent
     * @return string
     */
    function generationPdfFactureOffre($commande_id, $commande_date, $montant_total, $echeance, $description, $quantite, $prix_unitaire, $nom_souscripteur, $email_souscripteur, $rue, $adresse, $ville, $pays, $beneficiaire)
    {
        //return view('impression_offre');
        try {
            $pdf = PDF::loadView('impression_offre', ['commande_id' => $commande_id, 'commande_date' => $commande_date, 'montant_total' => number_format($montant_total, 2, ',', ' '), 'echeance' => $echeance, 'description' => mb_strtoupper($description), 'quantite' => $quantite, 'prix_unitaire' => number_format($prix_unitaire, 2, ',', ' '), 'nom_souscripteur' => $nom_souscripteur, 'email_souscripteur' => $email_souscripteur, 'rue' => $rue, 'adresse' => $adresse, 'ville' => $ville, 'pays' => $pays, 'beneficiaire' => $beneficiaire]);
            return ['output' => $pdf->output(), 'stream' => $pdf->stream($description.".pdf")];
        }catch (\Exception $exception){
            //$exception
        }
    }

    function visualiser($slug)
    {
        $consultationMedecine = ConsultationMedecineGenerale::with('operationables.contributable','files')->whereSlug($slug)->first();

        $auteur = getAuthor("ConsultationMedecineGenerale",$consultationMedecine->id,"create");
        $updateAuteurs = getUpdatedAuthor("ConsultationMedecineGenerale",$consultationMedecine->id,"update");
        $signature = null;
        $medecins = [];
        $praticiens = new Praticien();
        $auteurs = [];
        if (!is_null($auteur)){
            if ($auteur->auteurable_type == 'Praticien'){
                $praticien = Praticien::with('user')->find($auteur->auteurable_id);
                $praticiens = $praticien ?? '';
                $signature = $praticien->signature ?? '';
            }else if($auteur->auteurable_type == 'Medecin controle') {
                $medecin = MedecinControle::with('user')->find($auteur->auteurable_id);
                $praticiens = $medecin ?? '';
                $signature = $medecin->signature ?? '';
            }
        }

        foreach ($updateAuteurs as $item){
            if ($item->auteurable_id != $auteur->auteurable_id){
                if (!in_array($item->auteurable_id,$auteurs)){
                    if ($item->auteurable_type == 'Medecin controle'){
                        $medecin = MedecinControle::with('user')->find($item->auteurable_id);
                        array_push($medecins,$medecin);
                    }
                    array_push($auteurs,$item->auteurable_id);
                }
            }
        }
        //Recuperation des contributeurs de la consultation
        $cContributeurs = [];
        foreach($consultationMedecine->operationables as $operationable){
            array_push($cContributeurs,$operationable['contributable']['id']);
        }

        $pContributeurs = Praticien::with('user')->whereIn('user_id',$cContributeurs)->latest()->get();
        $mContributeurs = MedecinControle::with('user')->whereIn('user_id',$cContributeurs)->latest()->get();

        if(isJSON($consultationMedecine->examen_complementaire)){
            $examen_complementaire = _group_by(json_decode($consultationMedecine->examen_complementaire, true),"reference");
        }else if(is_array($consultationMedecine->examen_complementaire)){
            $examen_complementaire = _group_by($consultationMedecine->examen_complementaire,"reference");
        }else if(is_string($consultationMedecine->complementaire)){
            $complementaire = $consultationMedecine->complementaire;
        }else{
            $examen_complementaire = null;
        }


        if(isJSON($consultationMedecine->examen_clinique)){
            // dd($consultationMedecine->examen_clinique);
            $examen_clinique = _group_by(json_decode($consultationMedecine->examens, true),"reference");
        }else if(is_array($consultationMedecine->examens)){
            $examen_clinique = _group_by($consultationMedecine->examens,"reference");
        }else if(is_string($consultationMedecine->examens)){
            $examen_clinique = $consultationMedecine->examen_clinique;
            // dd($examen_clinique);
        }else{
            $examen_clinique = $consultationMedecine->examens;
        }
        // dd($consultationMedecine);

        if(!is_null($consultationMedecine->examens)){
           $examen_clinique = _group_by(is_array($consultationMedecine->examens)?$consultationMedecine->examens:json_decode($consultationMedecine->examens, true),"reference");
        }

        if(!is_null($consultationMedecine->anamneses)){
          $anamneses = _group_by(is_array($consultationMedecine->anamneses)?$consultationMedecine->anamneses:json_decode($consultationMedecine->anamneses, true),"reference");
        }else{
            $anamneses = null;
        }

        if(!is_null($consultationMedecine->anamese)){
            $anamese = $consultationMedecine->anamese;
        }else{
            $anamese = $consultationMedecine->anamese;
        }

        if(!is_null($consultationMedecine->complementaire)){
            $complementaire = $consultationMedecine->complementaire;
        }else{
            $complementaire = $consultationMedecine->complementaire;
        }



        // if(is_string($consultationMedecine->anamneses)){
        //     $anamneses = $consultationMedecine->anamneses;
        // }else{
        //     $anamneses = $consultationMedecine->anamneses;
        // }
        // dd($consultationMedecine);

        if(!is_null($consultationMedecine->diasgnostic)){
          $diasgnostic = is_array($consultationMedecine->diasgnostic)?$consultationMedecine->diasgnostic:json_decode($consultationMedecine->diasgnostic, true);
        }else{
            $diasgnostic = null;
        }

        $data = compact('consultationMedecine','signature','medecins','praticiens','mContributeurs','pContributeurs','examen_complementaire','examen_clinique','anamneses','diasgnostic','anamese','complementaire');
        $pdf = PDF::loadView('rapport',$data);

        $nom  = patientLastName($consultationMedecine);
        $prenom = patientFirstName($consultationMedecine);
        $date= $consultationMedecine->date_consultation;

        // $path = storage_path().'/app/public/pdf/'.'Generale_'.$nom.'_'.$prenom.'_'.$date.'.pdf';
        // $pdf->save($path);

        // return  response()->json(['link'=>'Generale_'.$nom.'_'.$prenom.'_'.$date.'.pdf']);
        return $pdf->stream('Generale_'.$nom.'_'.$prenom.'_'.$date.'.pdf');
        // response()->json(['link' => route('facture.offre', $commande_id)]);
    }
}


if(!function_exists('EnvoieDeFactureApresPaiementPrestation'))
{
    /**
     * @param $string_with_accent
     * @return string
     */
    function EnvoieDeFactureApresPaiementPrestation($commande_id, $commande_date, $montant_total, $echeance, $description, $mode_paiement, $nom_souscripteur, $email_souscripteur, $rue, $adresse, $ville, $pays, $beneficiaire)
    {
        //return view('impression_offre');
        try {
            $pdf = generationPdfPaiementPrestation($commande_id, $commande_date, $montant_total, $echeance, $description, $mode_paiement, $nom_souscripteur, $email_souscripteur, $rue, $adresse, $ville, $pays, $beneficiaire);
            Mail::to($email_souscripteur)->cc("contrat@medicasure.com")->send(new PaiementPrestation($pdf['output'], $nom_souscripteur, $beneficiaire, $description));
        }catch (\Exception $exception){
            //$exception
        }
    }
}


if(!function_exists('generationPdfPaiementPrestation'))
{
    /**
     * @param $string_with_accent
     * @return string
     */
    function generationPdfPaiementPrestation($commande_id, $commande_date, $montant_total, $echeance, $description, $mode_paiement, $nom_souscripteur, $email_souscripteur, $rue, $adresse, $ville, $pays, $beneficiaire)
    {
        //return view('impression_offre');
        try {
            $pdf = PDF::loadView('impression_prestation', ['commande_id' => $commande_id, 'commande_date' => $commande_date, 'montant_total' => number_format($montant_total, 2, ',', ' '), 'echeance' => $echeance, 'description' => mb_strtoupper($description), 'mode_paiement' => $mode_paiement, 'nom_souscripteur' => $nom_souscripteur, 'email_souscripteur' => $email_souscripteur, 'rue' => $rue, 'adresse' => $adresse, 'ville' => $ville, 'pays' => $pays, 'beneficiaire' => $beneficiaire]);
            return ['output' => $pdf->output(), 'stream' => $pdf->stream($description.".pdf")];
        }catch (\Exception $exception){
            //$exception
        }
    }
}


if(!function_exists('ConversionEurotoXaf'))
{
    /**
     * @param $montant
     * @return int
     */
    function ConversionEurotoXaf($montant)
    {
        $base_uri = 'https://api.exchangerate.host/latest';

        try {
            $client = new Client(['base_uri' => $base_uri]);
            $response = $client->request('GET', $base_uri);
            $responseArray = json_decode($response->getBody()->getContents(), true);
            if($responseArray['success'] == true){
                $total = ceil($montant * $responseArray['rates']['XAF']);
                return $total;
            }

            //return $responseArray;

        } catch (Exception $exception) {
            return response()->json(['erreur'=>$exception->getMessage()],419);
        }

    }
}
if(!function_exists('ConversionXafToEuro'))
{
    /**
     * @param $montant
     * @return int
     */
    function ConversionFromAndTo($montant, $from = "XAF", $to = "EUR")
    {
        $base_uri = "https://api.exchangerate.host/latest?base=$from";

        try {
            $client = new Client(['base_uri' => $base_uri]);
            $response = $client->request('GET', $base_uri);
            $responseArray = json_decode($response->getBody()->getContents(), true);
            if($responseArray['success'] == true){
                $total = ceil($montant * $responseArray['rates'][$to]);
                return $total;
            }

            //return $responseArray;

        } catch (Exception $exception) {
            return response()->json(['erreur'=>$exception->getMessage()],419);
        }

    }
}


if(!function_exists('ProcessAfterPayment'))
{
    /**
     * @param $string_with_accent
     * @return string
     */
    function ProcessAfterPayment($payment, $patient = null)
    {
        $affiliation = AffiliationSouscripteur::where([["type_contrat",$payment->commande->offres_packages_id],["user_id",$payment->souscripteur_id]])->first();
        if(!is_null($patient)){

                $affiliation_old = Affiliation::where([["patient_id",$patient],["package_id",$payment->commande->offres_packages_id]])->first();

                if($affiliation_old->status_paiement =="NON PAYE"){
                    $affiliation_old->status_paiement = "PAYE";
                }else{
                    $affiliation_old->renouvelle += 1;
                    $payment->status_contrat = "Renouvelé";
                    $affiliation_old->date_fin = Carbon::parse($affiliation_old->date_fin)->addYears(1)->format('Y-m-d');
                }
                $affiliation_old->save();
        }
        // if($affiliation == ''){
            $affiliation = AffiliationSouscripteur::create([
                'user_id'=>$payment->souscripteur_id,
                'type_contrat'=>$payment->commande->offres_packages_id,
                'nombre_paye'=>$payment->commande->quantite,
                'nombre_restant'=>$payment->commande->quantite,
                'montant'=>$payment->montant,
                'cim_id'=>$payment->commande->id,
                'date_paiement'=> null,
            ]);
        // }else{
        //     $affiliation = AffiliationSouscripteur::create([
        //         'user_id'=>$payment->souscripteur_id,
        //         'type_contrat'=>$payment->commande->offres_packages_id,
        //         'nombre_paye'=>$payment->commande->quantite,
        //         'nombre_restant'=>$payment->commande->quantite,
        //         'montant'=>$payment->montant,
        //         'cim_id'=>$payment->commande->id,
        //         'date_paiement'=>'2023-01-20',
        //     ]);
        //     // $affiliation->nombre_paye =$affiliation->nombre_paye + (int)$payment->commande->quantite;
        //     // if($payment->status_contrat != "Renouvelé"){
        //     //     $affiliation->nombre_restant =$affiliation->nombre_restant + (int)$payment->commande->quantite;
        //     // }
        //     // $affiliation->save();
        // }
       /**
        * envoie de la facture au souscripteur
        */
        $commande_id = $payment->commande->id;
        $commande_date = $payment->commande->date_commande;
        $montant_total = $payment->montant;
        $echeance =  "13/02/2022";
        $description = $affiliation->typeContrat->description_fr;
        $quantite =  $payment->commande->quantite;
        $prix_unitaire = $affiliation->typeContrat->montant;
        $nom_souscripteur = mb_strtoupper($affiliation->souscripteur->user->nom).' '.ucfirst($affiliation->souscripteur->user->prenom);
        $email_souscripteur = $affiliation->souscripteur->user->email;
        $telephone = $affiliation->souscripteur->user->telephone;
        $rue =  $affiliation->souscripteur->user->quartier;
        $adresse =  $affiliation->souscripteur->user->adresse;
        $ville = $affiliation->souscripteur->user->code_postal.' - '.$affiliation->souscripteur->user->ville;
        $pays = $affiliation->souscripteur->user->pays;
        $beneficiaire ="FOUKOUOP NDAM Rebecca";

        /**
         * Notification sur slack
         */
        $env = strtolower(config('app.env'));
        $url_global = "";
        if ($env == 'local')
            $url_global = config('app.url_loccale');
        else if ($env == 'staging')
            $url_global = config('app.url_stagging');
        else
            $url_global = config('app.url_prod');
        $url_global = $url_global."/payment-management/medicasure";
        $message = "*$nom_souscripteur* a acheté $quantite $description à *$montant_total Euros*\nemail: $email_souscripteur \ntéléphone: $telephone \n <$url_global|*Cliquer ici pour plus de détails*>";
        // Send notification to affilié channel
        if($env == 'production'){
            $affiliation->setSlackChannel('souscription')->notify(new SouscriptionAlert($message,null));
        }

        EnvoieDeFactureApresSouscription($commande_id, $commande_date, $montant_total, $echeance, $description, $quantite, $prix_unitaire, $nom_souscripteur, $email_souscripteur, $rue, $adresse, $ville, $pays, $beneficiaire);

        if(!is_null($patient)){
            return $affiliation_old->slug;
        }
    }
}

if(!function_exists('DelaiDePriseEnChargeParOperations'))
{
    function DelaiDePriseEnChargeParOperations($operations)
    {
        $operations = $operations->map(function ($item) {
            $date_heure_prevue = Carbon::parse($item->date_heure_prevue);
            $date_heure_effectif = Carbon::parse($item->date_heure_effectif);
            $ecart_en_second = $date_heure_effectif->DiffInSeconds($date_heure_prevue);
            return $ecart_en_second;
        });
        return $operations->avg();
    }
}

if(!function_exists('ConversionDesDelais'))
{
    function ConversionDesDelais($operations)
    {
        return CarbonInterval::seconds($operations)->cascade()->forHumans(['long' => true, 'parts' => 3]);
    }
}

if(!function_exists('AjoutDuneAffiliation')){
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\PersonnnalException
     * @param $string_with_accent
     * @return string
     */
    function AjoutDuneAffiliation(Request $request){
        /**
         * Affiliation Souscripteur
         */
        //$affiliation_old = Affiliation::where([["patient_id",$patient],["package_id",$payment->commande->offres_packages_id]])->first();
        if($request->lien_parente){
            $souscripteur_id = $request->souscripteur_id;
            $commande_id = $request->commande_id;

            // Recupération des informations relative à la commande
            $commande =  \App\Models\AffiliationSouscripteur::where("id",$commande_id)->first();

            /* $validator = Validator::make($request->all(),[
                'email'=>'required|email|unique:users'
                ]);

            if ($validator->fails()){
                return  response()->json($validator->errors()->all(),400);
            } */


            // Récupération des informations relatifs au souscripteur
            $souscripteur = Souscripteur::with('user')->where('user_id','=',$souscripteur_id)->first();
            if ($commande){
                if ($commande->nombre_restant > 0){
                    // Récupération des informations nécessaire pour la création du compte utilisateur medsurlink
                    $userInformation = configurerUserMedsurlink($request);

                    // Création du compte utilisateur du patient medsurlink
                    $password_new = substr(bin2hex(random_bytes(10)), 0, 7);
                    $passwordPatient = Hash::make($password_new);
                    $user = genererCompteUtilisateurMedsurlink($userInformation,$passwordPatient,'1');

                    // Enregistrement des informations personnels du patient
                    $patient = Patient::create([
                        'user_id' => $user->id,
                        'sexe'=>$request->sexe,
                        'age'=>  Carbon::parse($request->date_de_naissance)->age,
                        'date_de_naissance'=>$request->date_de_naissance,
                        'souscripteur_id' => $souscripteur->user_id,
                    ]);

                    // Enregistrement des informations de question secrete et reponse secrete
                    ReponseSecrete::create(['reponse'=>$request->reponse,'question_id'=>$request->question_id,'user_id'=>$user->id]);

                    // Assignation du role patient
                    $user->assignRole('Patient');

                    //Génération du dossier médical
                    $dossier = genererDossierMedical($patient->user_id);

                    //Ajout du patient à la liste de suivi
                    $suivi = ajouterPatientAuSuivi($dossier->id,1);

                    // Ajout du souscripteur à la liste des souscripteurs du patient
                    CreationPatientSouscripteur($request, $patient);

                    // Réduction du nombre de commande restante

                    // Génération du contrat
                    $patientMedicasure = transformerEnAffilieMedicasure($patient);
                    $souscripteurMedicasure = transformerEnSouscripteurMedicasure($souscripteur);
                    $detailContrat = transformerCommande($commande,$request,$souscripteur->user->pays);


                    $affiliation = CreationAffiliation($request, $patient, $commande);

                    if($request->plaintes){
                        $plaintes = AjoutDesPlaintes($affiliation, $request->plaintes);
                    }

                    // envoie de mail à contract
                    $package = Package::find($commande->type_contrat);
                        $affiliation->motifs()->sync($plaintes);
                    // Log::info("affiliation".$affiliation);
                    Mail::to('contrat@medicasure.com')->send(new NouvelAffiliation($user->nom, $user->prenom, $user->telephone, $affiliation->motifs, $request->niveau_urgence, $request->contact_name, $request->contact_firstName, $request->contact_phone, $package->description_fr, $request->paye_par_affilie,$souscripteur,$affiliation, $request->urgence));
                    $affiliation_old = Affiliation::where([["patient_id",$patient->user_id],["souscripteur_id",$souscripteur->user_id]])->first();
                    $commande = reduireCommandeRestante($commande->id, $souscripteur->user_id, $patient->user_id, $package->description_fr, $affiliation_old->slug);

                    defineAsAuthor("Affiliation",$affiliation->id,'create',$request->patient_id);
                    //genererContrat($detailContrat+$souscripteurMedicasure+$patientMedicasure);

                    // Envoi sms et mail de creation de compte au patient
                    sendUserInformationViaSms($user,$password_new);
                    sendUserInformationViaMail($user,$password_new);

                    // Envoi sms et mail de mise à jour de compte au souscripteur
                    notifierMiseAJourCompte($souscripteur,$patient);


                    return response()->json(['patient'=>$patient]);
                }else{
                    app('App\Http\Controllers\Api\AffiliationSouscripteurController')->revealError('commande_restant','vous ne pouvez plus ajouter de patients');
                }
            }else{
                app('App\Http\Controllers\Api\AffiliationSouscripteurController')->revealError('commande_not_definie','La commande dont l\'identifiant a été transmis n\'existe pas');
            }

        }
        else if($request->lien){
            
            /**
             * Affiliation par les amas
             */
            app('App\Http\Controllers\Api\AffiliationController')->Affiliated($request);
            $patient = Patient::with('user')->where('user_id', $request->patient_id)->first();
            if($patient){
                $package_id = $request->package_id;
                $souscripteur_id = $request->souscripteur_id;
                $souscription = CommandePackage::where(['souscripteur_id'=> $souscripteur_id, 'offres_packages_id'=> $package_id])->latest()->first();
                
                // Ajout du souscripteur à la liste des souscripteurs du patient
                CreationPatientSouscripteur($request, $patient);
                //reduction du nombre de commande du Souscripteur
                if(is_null($souscription)){
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
                }


                $commande = AffiliationSouscripteur::where(['user_id'=> $souscription->souscripteur_id, 'cim_id' => $souscription->id])->where('nombre_restant', '>', 0)->latest()->first();
                if(is_null($commande)){
                    $package = $souscription->offres_package;
                    $commande = AffiliationSouscripteur::create([
                        'user_id'=> $request->souscripteur_id,
                        'nombre_paye'=> 1,
                        'nombre_restant'=> 1,
                        'montant' => $package->montant,
                        'cim_id'=>$request->package_id,
                        'date_paiement'=>null,
                    ]);
                }
                $affiliation = CreationAffiliation($request, $patient);
                if($request->plaintes){
                    $plaintes = AjoutDesPlaintes($affiliation, $request->plaintes);
                }
                $affiliation->motifs()->sync($plaintes);
                $patient->souscripteur_id = $request->souscripteur_id;
                // $user->nom, $patient->user->prenom, $user->telephone,
                $souscripteur = Souscripteur::with('user')->where('user_id','=',$souscripteur_id)->first();
                // Log::info('info souscripteur'.$souscripteur);
                // Log::info('info patient'.$patient);
                
                Mail::to('contrat@medicasure.com')->send(new NouvelAffiliation($patient->user->nom, $patient->user->prenom, $patient->user->telephone, $affiliation->motifs, $request->niveau_urgence, $request->contact_name, $request->contact_firstName, $request->contact_phone, $package->description_fr, $request->paye_par_affilie,$souscripteur,$affiliation, $request->urgence));
                $patient->save();
                
                $cim = Package::where('id', $request->package_id)->first();
                $affiliation_old = Affiliation::where([["patient_id",$patient->user_id],["souscripteur_id",$request->souscripteur_id]])->first();
                $commande = reduireCommandeRestante($commande->id,  $request->souscripteur_id, $request->patient_id, $cim->description_fr, $affiliation_old->slug);

                notifierMiseAJourCompte($souscripteur,$patient);
                
                
                // Log::info('affiliation'.$affiliation);
                return response()->json(['affiliation' => $affiliation]);
            }else{
                return response()->json(['erreur' => "Le patient n'existe pas"], 419);
            }
        }
    }
}

/**
 * fonction de recuperation des plaintes
 */
if(!function_exists('AjoutDesPlaintes')){

    function AjoutDesPlaintes($affiliation, $mes_plaintes){
        if(!is_array($mes_plaintes)){
            $mes_plaintes = explode(",", $mes_plaintes);
        }
        $plaintes = [];
        foreach($mes_plaintes as $plainte){
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

        $affiliation->motifs()->sync($plaintes);
        $affiliation->cloture()->create([]);
        /**
         * creation d'une ligne de temps après une affiliation
        */
        $ligne_temps = LigneDeTemps::create(['dossier_medical_id' => $affiliation->patient->dossier->id, 'motif_consultation_id' => $plaintes[0], 'etat' => 1, 'date_consultation' => date('Y-m-d'), 'affiliation_id' => $affiliation->id]);
        $ligne_temps->motifs()->sync($plaintes);
        return $plaintes;
    }
}

if(!function_exists('CreationAffiliation')){

    function CreationAffiliation($request, $patient, $commande = null){
        // Log::info('creation affiliation');
        $affiliation = Affiliation::create([
            "patient_id"=> $request->lien ? $request->patient_id: $patient->user_id,
            "souscripteur_id"=>$request->souscripteur_id,
            "package_id"=>$request->lien ? $request->package_id : $commande->type_contrat,
            "date_signature"=>Carbon::now(),
            "status_contrat"=> $request->lien ? $request->status_contrat: "Généré",
            "status_paiement"=> $request->lien ? $request->status_paiement: "PAYE",
            "renouvelle"=>0,
            "expire"=>0,
            "code_contrat"=>$patient->dossier->numero_dossier,
            "niveau_urgence"=>$request->lien ?$request->niveau_urgence: $request->urgence,
            "plainte" => $request->plainte,
            "contact_firstName" => $request->contact_firstName,
            "contact_name" => $request->contact_name,
            "contact_phone" => $request->contact_phone,
            'personne_contact' => $request->personne_contact,
            'paye_par_affilie' => $request->paye_par_affilie,
            'selected' => $request->selected,
            "nombre_envois_email"=>0,
            "expire_email"=>0,
            "nom"=>'Annuelle',
            "date_debut"=>  $request->date_debut ?? Carbon::now(),
            "date_fin"=>Carbon::now()->addYears(1)->format('Y-m-d')
        ]);
        return $affiliation;
    }

}

if(!function_exists('CreationPatientSouscripteur')){

    function CreationPatientSouscripteur($request, $patient){
        PatientSouscripteur::create([
            'financable_type'=>'Souscripteur',
            'financable_id'=> $request->souscripteur_id,
            'patient_id'=> $request->lien ? $request->patient_id: $patient->user_id,
            'lien_de_parente' => $request->lien ? $request->lien : $request->lien_parente
        ]);
    }
}
