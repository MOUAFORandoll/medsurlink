<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Traits\PersonnalErrors;
use App\Models\Patient;
use App\Models\Souscripteur;
use App\Models\TimeActivite;
use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
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


                    // Création du compte utilisateur medsurlink
                    $passwordPatient = substr(bin2hex(random_bytes(10)), 0, 7);
                    $user = genererCompteUtilisateurMedsurlink($userInformation,$passwordPatient,'0');

                    // Assignation du role souscripteur
                    $user->assignRole('Souscripteur');

                    // Enregistrement des informations personnels du souscripteur
                    $souscripteur = Souscripteur::create(['user_id' => $user->id,'sexe'=>'']);

                    // Enregistrement des informations relative aux commandes
                    $commande = enregistrerCommande($user,$line_item,$cim_id);

                    // Authentification de l'utilisateur
                    $token = $user->createToken('Commande token')->accessToken;
                    $tokenInfo = [];
                    //        $tokenInfo['token_type']= 'Bearer';
                    //        $tokenInfo['expires_in']= 86399;
                    $tokenInfo = $token;
                    //        $tokenInfo = collect($tokenInfo);
                    //        $user->roles;
                    //        Auth::login($user);
                    //        $time = TimeActivite::create([
                    //            'date'=>Carbon::now()->format('Y-m-d'),
                    //            'start'=>Carbon::now()->format('H:i')
                    //        ]);
                    //        $user['time_slug'] = $time->slug;
                    //        $user['isEtablissement'] = isComptable();
                    //        $tokenInfo->put('token_expires_at',Carbon::parse()->addSeconds($tokenInfo['expires_in']));
                    //        $tokenInfo->put('user', $user);

                    // Envoi du mail avec mot de passe souscripteur
                    try{
                        sendUserInformationViaMail($user,$passwordPatient);
                    }catch (\Swift_TransportException $transportException){
                        $message = "L'operation à reussi mais le mail n'a pas ete envoye. Verifier votre connexion internet ou contacter l'administrateur";
                        return response()->json(['souscripteur'=>$user, "message"=>$message]);
                    }

                    return response()->json(['reponse'=>$tokenInfo],200) ;
                }
                return response()->json(['reponse'=>'Mauvais status de paiement de commande'],404) ;
            }catch ( ClientException $exception){
                return response()->json(['reponse'=>'Mauvais identifiant de commande'],404) ;
            }
        }else{
            return response()->json(['reponse'=>'La commande existe déjà'],404) ;
        }

    }

    public function storeSouscripteurRedirect(Request $request,$cim_id)
    {
        $token = $this->storeSouscripteur($request,$cim_id);
        $updatePath = 'token=';
        $reponse = $token->getOriginalContent()['reponse'];

        $env = strtolower(config('app.env'));
        if ($token->getStatusCode() == 200){
            $updatePath += $reponse;
        }else{
            $updatePath = 'erreur='.$reponse;
        }
        if ($env === 'local')
            return  redirect('http://localhost:8000/login?'.$updatePath);
        else if ($env === 'staging')
            return  redirect('https://www.staging.medsurlink.com/contrat-prepaye?'.$updatePath);
        else
            return  redirect('https://www.medsurlink.com/contrat-prepaye?'.$updatePath);

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

        // Récupération des informations relatifs au souscripteur
        $souscripteur = Souscripteur::with('user')->where('user_id','=',$souscripteur_id)->first();

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
