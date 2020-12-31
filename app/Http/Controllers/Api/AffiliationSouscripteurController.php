<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Traits\PersonnalErrors;
use App\Models\Patient;
use App\Models\ReponseSecrete;
use App\Models\Souscripteur;
use App\Models\TimeActivite;
use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Psy\Util\Json;

class AffiliationSouscripteurController extends Controller
{
    use PersonnalErrors;
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
     * Enregistrement d'un souscripteur à partir des informations de la commande sur CIM.MEDICASURE.COM
     * et authentification
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeSouscripteur(Request $request,$cim_id)
    {
        if (!laCommandeExisteElle($cim_id)){
            // Récupération des informations de la commande end point cim.medicasure.com
            try {
                $client = new Client();
                $url = 'https://cim.medicasure.com/wp-json/wc/v2/orders/'.$cim_id;
                $res = $client->request('GET', $url, [
                    'auth' => ['ck_52c5cdaefeb263227e25090df598e4b74a027c03', 'cs_97ea123ce8c28d6b69cc4bd3088cd9cd173c68a6']
                ]);

                $affiliation = json_decode($res->getBody()->getContents());
                if(strtoupper($affiliation->status) == 'COMPLETED' ){
                    $request = $affiliation->billing;
                    $line_item = $affiliation->line_items[0];
                    $date_paiement = $affiliation->date_paid;
                    $userInformation = [];
                    $userInformation['nom']=$request->last_name;
                    $userInformation['prenom']=$request->first_name;
                    $userInformation['email']=$request->email;
                    $userInformation['nationalite']=$request->country;
                    $userInformation['quartier']=$request->address_1;
                    $userInformation['code_postal']=$request->postcode;
                    $userInformation['ville']=$request->city;
                    $userInformation['pays']=$request->country;
                    $userInformation['telephone']=$request->phone;
                    $userInformation['adresse']=$request->address_2;


                    // Création du compte utilisateur medsurlink du souscripteur
                    $passwordSouscripteur = substr(bin2hex(random_bytes(10)), 0, 7);
                    $user = genererCompteUtilisateurMedsurlink($userInformation,$passwordSouscripteur,'0');

                    // Assignation du role souscripteur
                    $user->assignRole('Souscripteur');

                    // Enregistrement des informations personnels du souscripteur
                    $souscripteur = Souscripteur::create(['user_id' => $user->id,'sexe'=>'']);

                    // Enregistrement des informations relative aux commandes
                    $commande = enregistrerCommande($user,$line_item,$cim_id,$date_paiement);

                    //Definition des identifiants pour connexion
                    $tokenInfo =$passwordSouscripteur.'medsur'. $request->email;

                    // Envoi du mail avec mot de passe souscripteur
                    try{
                        sendUserInformationViaMail($user,$passwordSouscripteur);
                    }catch (\Swift_TransportException $transportException){
                        $message = "L'operation à reussi mais le mail n'a pas ete envoye. Verifier votre connexion internet ou contacter l'administrateur";
                        return response()->json(['reponse'=>$tokenInfo,'souscripteur'=>$user, "message"=>$message]);
                    }
                    return response()->json(['reponse'=>$tokenInfo],200) ;
                }
                return response()->json(['reponse'=>'error_bad_payment'],404) ;
            }catch ( ClientException $exception){
                return response()->json(['reponse'=>'error_bad_command'],404) ;
            }
        }else{
            return response()->json(['reponse'=>'error_exist'],404) ;
        }

    }

    public function storeSouscripteurRedirect(Request $request,$cim_id)
    {
        $token = $this->storeSouscripteur($request,$cim_id);
        $updatePath = 'token=';
        $reponse = $token->getOriginalContent()['reponse'];

        $env = strtolower(config('app.env'));
        if ($token->getStatusCode() == 200){
            $updatePath = 'status=success&'.$updatePath.$reponse;
        }else{
            $updatePath = 'status='.$reponse.'&'.$updatePath;
        }
        if ($env === 'local')
            return  redirect('http://localhost:8080/contrat-prepaye/add?'.$updatePath);
        else if ($env === 'staging')
            return  redirect('https://www.staging.medsurlink.com/contrat-prepaye/add?'.$updatePath);
        else
            return  redirect('https://www.medsurlink.com/contrat-prepaye/add?'.$updatePath);
    }

    /**
     * Enregistrement d'un patient grace à une commande prépayé
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\PersonnnalException
     */
    public function storePatient(Request $request)
    {
        $souscripteur_id = $request->souscripteur_id;
        $commande_id = $request->commande_id;

        // Recupération des informations relative à la commande
        $commande =  \App\Models\AffiliationSouscripteur::whereId($commande_id)->first();

       $validator = Validator::make($request->all(),[
           'question_id'=>'required|integer|exists:questions,id',
           'reponse'=>'required|string',
           'commande_id'=>'required|integer|exists:affiliation_souscripteurs,id'
        ]);

       if ($validator->fails()){
           return  response()->json($validator->errors()->all(),400);
       }

        // Récupération des informations relatifs au souscripteur
        $souscripteur = Souscripteur::with('user')->where('user_id','=',$souscripteur_id)->first();
        if ($commande){
            if ($commande->nombre_restant > 0){
                // Récupération des informations nécessaire pour la création du compte utilisateur medsurlink
                $userInformation = configurerUserMedsurlink($request);

                // Création du compte utilisateur du patient medsurlink
                $passwordPatient = substr(bin2hex(random_bytes(10)), 0, 7);
                $user = genererCompteUtilisateurMedsurlink($userInformation,$passwordPatient,'1');

                // Enregistrement des informations personnels du patient
                $patient = Patient::create([
                    'user_id' => $user->id,
                    'sexe'=>$request->sexe,
                    'date_de_naissance'=>$request->date_de_naissance
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
                $patient->ajouterSouscripteur($souscripteur_id);

                // Réduction du nombre de commande restante
                $commande = reduireCommandeRestante($request->commande_id);

                // Génération du contrat
                $patientMedicasure = transformerEnAffilieMedicasure($patient);
                $souscripteurMedicasure = transformerEnSouscripteurMedicasure($souscripteur);
                $detailContrat = transformerCommande($commande,$request,$souscripteur->user->pays);
                genererContrat($detailContrat+$souscripteurMedicasure+$patientMedicasure);

                // Envoi sms et mail de creation de compte au patient
                sendUserInformationViaSms($user,$passwordPatient);
                sendUserInformationViaMail($user,$passwordPatient);

                // Envoi sms et mail de mise à jour de compte au souscripteur
                notifierMiseAJourCompte($souscripteur,$patient);


                return response()->json(['patient'=>$patient]);
            }else{
                $this->revealError('commande_restant','Commande restant égale 0, vous ne pouvez plus ajouter de patients');
            }
        }else{
            $this->revealError('commande_not_definie','La commande dont l\'identifiant a été transmis n\'existe pas');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function affiliationRestante($id){
        $commande = resteDeCommande($id);

        return response()->json(['commande'=>$commande]);
    }




}
