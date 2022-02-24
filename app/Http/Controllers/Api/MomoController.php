<?php

namespace App\Http\Controllers\Api;

use App\User;
use Carbon\Carbon;
use Psy\Util\Json;
use App\Models\CodePromo;
use Illuminate\Support\Str;
use App\Models\PaymentOffre;
use App\Models\Souscripteur;
use Illuminate\Http\Request;
use App\Models\CommandePackage;
use App\Http\Controllers\Controller;
use App\Models\NotificationPaiement;
use App\Models\AffiliationSouscripteur;
use Illuminate\Support\Facades\Validator;
use App\Models\ContratIntermediationMedicale;

class MomoController extends Controller
{
    public $apiKey = "3f0906f05f774dbfb6829680ad329701";
    public $apiUser = "068284d4-09a2-44c5-ad72-ebc1f4e483d0";
    public $subscriptionKey = 'fa60b91d41124fcb9bbe244d54c5a94f';
    public $host = 'https://proxy.momoapi.mtn.com/collection/';
    public $base64Code = 'MDY4Mjg0ZDQtMDlhMi00NGM1LWFkNzItZWJjMWY0ZTQ4M2QwOjNmMDkwNmYwNWY3NzRkYmZiNjgyOTY4MGFkMzI5NzAx';
    public $currency = 'XAF';

    public function paid(Request $request){

//        createUser($this->subscriptionKey,$this->apiUser,$this->host);
//        $this->apiKey = getKey($this->subscriptionKey,$this->apiUser);
//        $this->base64Code = base64_encode($this->apiUser.':'.$this->apiKey);
        $code= explode(',',$request->get('identifiant'));
        $validator = Validator::make(['contract'=>$code],['contract'=>'required|exists:contrat_intermediation_medicales,contrat_code']);
        if ($validator->fails()) {
            return response()->json($validator->getMessageBag()->getMessages(), 419);
        }

//        Récupération du token pour effectuer le paiement
        $accessToken = getToken($this->subscriptionKey,$this->base64Code);

//          Définition des inforamations relatives à la somme et au compte à débiter
        $operation = array(
            'amount'=> $request->amount,
//            'amount'=> '200',
            'currency'=> $this->currency,
            'externalId'=> $request->get('identifiant'),
            "payer"=>[
                "partyIdType"=>"MSISDN",
                "partyId"=>'237'.$request->partyId,
            ],
            'payerMessage'=> "PaiementContratIntermediationMedicale",
            'payeeNote' => "PaiementContratIntermediationMedicale"
        );
//        Génération de l'identifiant unique du paiement
        $referenceId = $request->get('referenceId');

        $operation = json_encode($operation);
        $callbackUrl = 'https://www.medicasure.com/'.$request->get('identifiant').'/'.$referenceId.'/collections/callback';
//        Requete de Paiement
        $paiementInformation =  requestToPay($referenceId,'mtncameroon ',$this->subscriptionKey,$accessToken,$operation,$this->host,$callbackUrl);
        //Pour la nouvelle version on va retourner à ce stade ci le message le reference uuid et on va faire le test
//            de statut
        if($paiementInformation['responseCode'] == 202) {
            return response()->json(['reponse' => $paiementInformation, 'referenceId' => $referenceId,'accessToken'=>$accessToken]);
        } else{
            return response()->json(['statut'=>"FAILED",'reason'=>$paiementInformation['response']]);
        }
    }

    // Paiement via mobile
    public function paiementMomoMobile(Request $request, $subscriptionKey, $accessToken, $referenceId, $base64,$operation, $callbackUrl){

        $identifiant = $request->input('package_id');
        $access_Momo_token = getToken($subscriptionKey, $base64);
        $mp_token = requestToPay($referenceId, $environment='mtncameroon', $subscriptionKey, $accessToken, $operation, $host=null,$callbackUrl);

        $body =[
            //"notifUrl"=> url("om/paiement/".$commande->id."/".$mp_token."/notification/".$tokenInfo),
            "channelUserMsisdn"=> "658392349",
            "amount"=> $request->get('amount'),
            "subscriberMsisdn"=> $request->get('subscriberMsisdn'),
            "pin"=> "2019",
            "orderId"=> $identifiant,
            "description"=> "",
            "payToken"=> $mp_token
        ];

        // faire autres actions relative au paiement
        $reponse = procederAuPaiementOm($access_Momo_token,$body);
        return response()->json(['reponse'=>$reponse]);
    }

    public function statutPaiementMomo(Request $request){


    }

    public function notificationPaiement(Request $request,$identifiant,$uuid){
        //Notification du paiement par mail

        NotificationPaiement::create([
            "type"=>'MOMO',
            "code_contrat"=>$identifiant,
            "pay_token"=>$uuid,
            "statut"=>(json_decode(Json::encode($request->all())))->status,
            "reponse"=>Json::encode($request->all()),
        ]);
    }
    

    public function momoPaidByCustomer(Request $request){
        $accessToken = getToken($this->subscriptionKey,$this->base64Code);
        
        $operation = array(
            'amount'=> $request->amount,
            'currency'=> $this->currency,
            'externalId'=> "cimcam",//$request->get('identifiant'),
            "payer"=>[
                "partyIdType"=>"MSISDN",
                "partyId"=>'237'.$request->subscriberMsisdn,
            ],
            'payerMessage'=> "PaiementContratIntermediationMedicale",
            'payeeNote' => "PaiementContratIntermediationMedicale"
        );
//        Génération de l'identifiant unique du paiement
        $referenceId = $request->get('reference');

        $operation = json_encode($operation);

                // create user if not exist
                $tokenInfo = "";
                $passwordSouscripteur = "";
                $user = User::where("email",$request->get("email"))->first();
                $souscripteur = null;
                if($user == null) {
                    $userInformation = [];
                    $userInformation['nom']=$request->get("name");
                    $userInformation['prenom']=$request->get("prenom");
                    $userInformation['email']=$request->get("email");
                    $userInformation['nationalite']=$request->get("pays");
                    $userInformation['quartier']="";
                    $userInformation['code_postal']="";
                    $userInformation['ville']="";
                    $userInformation['pays']=$request->get("pays");
                    $userInformation['telephone']=$request->get("telephone");
                    $userInformation['adresse']="";
        
                    //dd($userInformation);
                    // Création du compte utilisateur medsurlink du souscripteur
                    $passwordSouscripteur = substr(bin2hex(random_bytes(10)), 0, 7);
                    $user = genererCompteUtilisateurMedsurlink($userInformation,$passwordSouscripteur,'0');
        
                    // Assignation du role souscripteur
                    $user->assignRole('Souscripteur');
        
                    // Enregistrement des informations personnels du souscripteur
                    $souscripteur = Souscripteur::create(['user_id' => $user->id,'sexe'=>'']);
        
                    //Definition des identifiants pour connexion
                    $tokenInfo =$passwordSouscripteur.'medsur'. $request->email;
                    // Envoi du mail avec mot de passe souscripteur
                    try{
                        sendUserInformationViaMail($user,$passwordSouscripteur);
                    }catch (\Swift_TransportException $transportException){
                        //$message = "L'operation à reussi mais le mail n'a pas ete envoye. Verifier votre connexion internet ou contacter l'administrateur";
                        //return response()->json(['reponse'=>$tokenInfo,'souscripteur'=>$user, "message"=>$message]);
                    }
                }else{
                    $souscripteur = Souscripteur::where("user_id",$user->id)->first();
                    if($souscripteur == null){
                        $souscripteur = Souscripteur::create(['user_id' => $user->id,'sexe'=>'']);
                    }
                    $tokenInfo = "checkout";
                }
        
                $commande =  CommandePackage::create([
                    "date_commande" => Carbon::now()->toDateTimeString(),
                    'quantite' =>$request->get('quantite'),
                    'offres_packages_id' =>$request->get('package_id'),
                    'souscripteur_id' => $souscripteur->user_id,
                ]);
                PaymentOffre::create([
                    "date_payment" => Carbon::now()->toDateTimeString(),
                    "montant" =>  $request->get('amount'),
                    'status' => 'EN ATTENTE',
                    'commande_id' =>$commande->id,
                    'souscripteur_id' => $souscripteur->user_id,
                ]);
       
        // $callbackUrl = url('api/paiement/momo/paymentStatus/'.$commande->id.'/'.$referenceId.'/collections/callback');
        $callbackUrl = '';
//        Requete de Paiement
        $paiementInformation =  requestToPay($referenceId,'mtncameroon ',$this->subscriptionKey,$accessToken,$operation,$this->host,$callbackUrl);
        //Pour la nouvelle version on va retourner à ce stade ci le message le reference uuid et on va faire le test
//            de statut
       // return $operation;
        if($paiementInformation['responseCode'] == 202) {
            return response()->json(['status'=>'SUCCESSFUL','reponse' => $paiementInformation, 'referenceId' => $referenceId,'accessToken'=>$accessToken]);
        } else{
            return response()->json(['status'=>"FAILED",'reason'=>$paiementInformation['response']]);
        }
    }

    public function momoPayementStatusByCustomer(Request $request,$identifiant,$token){
        //            Determination du status du paiement
        $referenceId = $request->get('referenceId');
        $accessToken = $request->get('accessToken');
        $callbackUrl = '';

        $paiementStatut = requestToPayStatus($referenceId,'mtncameroon ',$this->subscriptionKey,$accessToken,$callbackUrl);
        if (isset($original->paiementStatut)){
            return response()->json(['statut'=>'FAILED','reason'=>($paiementStatut->original)['erreur']]);
        }else{
            $reponse = json_decode($paiementStatut->getBody()->getContents(),true);

            if ($reponse['status'] == "SUCCESSFUL"){
                    NotificationPaiement::create([
                        "type"=>'Orange Money',
                        "code_contrat"=>$identifiant,
                        "pay_token"=>'',
                        "statut"=>'Success',
                        "reponse"=>Json::encode($request->all()),
                    ]);
        
                   $payment = PaymentOffre::where("commande_id",$identifiant)->first();
                   $payment->status = "SUCCESS";
                   $payment->save();
                   //dd($payment);
                   $affiliation = AffiliationSouscripteur::where([["type_contrat",$payment->commande->offres_packages_id],["user_id",$payment->souscripteur_id]])->first();
                   if($affiliation == null){
                    $affiliation = AffiliationSouscripteur::create([
                           'user_id'=>$payment->souscripteur_id,
                           'type_contrat'=>$payment->commande->offres_packages_id,
                           'nombre_paye'=>$payment->commande->quantite,
                           'nombre_restant'=>$payment->commande->quantite,
                           'montant'=>$payment->montant,
                           'cim_id'=>$payment->commande->id,
                           'date_paiement'=>null,
                       ]);
                   }else{
                       $affiliation->nombre_paye =$affiliation->nombre_paye + (int)$payment->commande->quantite;
                       $affiliation->nombre_restant =$affiliation->nombre_restant + (int)$payment->commande->quantite;
                       $affiliation->save();
                   }
        
                   if($token=="checkout"){
                    $updatePath = 'checkout';
                   }else{
                    $updatePath = 'contrat-prepaye/add?status=success&token='.$token;
                   }
        
                   $env = strtolower(config('app.env'));
                   if ($env === 'local')
                   return  redirect('http://localhost:8081/'.$updatePath);
                   //return redirect('http://localhost:8081/dashboard/user-management/patients/paiement-status/'.$slug);
                    else if ($env === 'staging')
                        return  redirect('https://www.staging.medsurlink.com/'.$updatePath);
                    else
                        return  redirect('https://www.medsurlink.com/'.$updatePath);
        
                }
                elseif ($reponse['data']['status'] == 'PENDING'){
                    $payment = PaymentOffre::where("commande_id",$identifiant)->first();
                    $payment->status = "PENDING";
                    $payment->save();
                    return response()->json(['status'=>'PENDING','reponse'=>$reponse]);
                }elseif ($reponse['data']['status'] == 'CANCELLED'){
                    $payment = PaymentOffre::where("commande_id",$identifiant)->first();
                    $payment->status = "CANCELLED";
                    $payment->save();
                    return response()->json(['status'=>'CANCELLED','reponse'=>$reponse]);
                }
            }
            
    }
}
