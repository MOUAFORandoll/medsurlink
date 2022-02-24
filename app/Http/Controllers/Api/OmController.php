<?php

namespace App\Http\Controllers\Api;

use App\User;
use Carbon\Carbon;
use Psy\Util\Json;
use App\Models\CodePromo;
use App\Models\PaymentOffre;
use App\Models\Souscripteur;
use Illuminate\Http\Request;
use App\Models\CommandePackage;
use App\Http\Controllers\Controller;
use App\Models\NotificationPaiement;
use App\Models\AffiliationSouscripteur;
use Illuminate\Support\Facades\Validator;
use App\Models\ContratIntermediationMedicale;

class OmController extends Controller
{
    public function getOmToken(){
        return response()->json(['access_token'=>getOmToken()]);
    }

    public function getMpToken(){
        $access_token = getOmToken();
        $mp_token = initierPaiement($access_token);
        return response()->json(['mp_token'=>$mp_token]);
    }

    public function paiementFromMedicasure(Request $request){
        
        $identifiant = $request->input('package_id');
        $reference = $request->input('reference');
        $subscriberMsisdn = $request->input('subscriberMsisdn');
        $validator=Validator::make(array('package'=>$identifiant,'subscriberMsisdn'=>$subscriberMsisdn),[
            'subscriberMsisdn'=>'required|digits_between:9,12',
            'package'=>'required|exists:offres_packages,id']);
        if ($validator->fails()){
            return response()->json(['error'=>$validator->errors()->getMessages()]);
        }
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

        $access_token = getOmToken();
        $mp_token = initierPaiement($access_token);
        $tokenInfo = "checkout";
        $body =[
            //"notifUrl"=> url("om/paiement/".$commande->id."/".$mp_token."/notification/".$tokenInfo),
            "notifUrl"=> 'https://webhook.site/71bde717-c4ba-430d-b037-a0ad7a97348c?',
            "channelUserMsisdn"=> "658392349",
            "amount"=> 50,
            "subscriberMsisdn"=> $request->get('subscriberMsisdn'),
            "pin"=> "2019",
            "orderId"=> $identifiant,
            "description"=> "",
            "payToken"=> $mp_token
        ];
        //$request->get('amount')

        $reponse = procederAuPaiementOm($access_token,$body);
        return response()->json(['reponse'=>$reponse]);
    }

    // Paiement via mobile
    public function paiementOmMobile(Request $request){

        $identifiant = $request->input('package_id');
        $access_token = getOmToken();
        $mp_token = initierPaiement($access_token);

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
        $reponse = procederAuPaiementOm($access_token,$body);
        return response()->json(['reponse'=>$reponse]);
    }


    public function InitierPaiement(){
        $accessToken = getOmToken();

    }

    public function notificationPaiement(Request $request,$identifiant,$pay_token){
        //Notification du paiement par mail

        NotificationPaiement::create([
            "type"=>'OM',
            "code_contrat"=>$identifiant,
            "pay_token"=>$pay_token,
            "statut"=>(json_decode(Json::encode($request->all())))->status,
            "reponse"=>Json::encode($request->all()),
        ]);
    }

    public function statutPaiement(Request $request,$identifiant,$payToken,$token){
        $access_token = getOmToken();
        $reponse = statutPaiementOm($access_token,$payToken);
        if (isset($data->reponse)){
            if (isset($status->reponse['data'])){
                if ($reponse['data']['status'] == 'SUCCESSFULL'){
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
        return response()->json(['statut'=>$reponse]);
    }
/*     public function souscripteurRedirectToMedsurlink($emailSouscripteur1)
    {
        //$token = $this->storeSouscripteur($request,$souscripteur_id);

        // Récupération des informations relatifs au souscripteur
        $visiteur = Visiteur::whereEmail($emailSouscripteur1)->first();
        $updatePath = 'token=';
        //dd($visiteur);
        //$reponse = $token->getOriginalContent()['reponse'];

        $env = strtolower(config('app.env'));

        $updatePath = 'status=success&'.$updatePath.$visiteur->email;

        if ($env === 'local')
            return  redirect('http://localhost:8080/contrat-prepaye/add?'.$updatePath);
        else if ($env === 'staging')
            return  redirect('https://www.staging.medsurlink.com/contrat-prepaye/add?'.$updatePath);
        else
            return  redirect('https://www.medsurlink.com/contrat-prepaye/add?'.$updatePath);
    } */

    public function omPaidByCustomer(Request $request){
        $access_token = getOmToken();
        $mp_token = initierPaiement($access_token);
        $body = [
            //"notifUrl"=> url('/')."/api/v1.0.0/om/".$mp_token."/notification",
            "notifUrl"=> url('/')."/api/v1.0.0/om/".$mp_token."/notification",
            "channelUserMsisdn"=> "658392349",
            "amount"=> 50,
            //"amount"=> $request->get('amount'),
            "subscriberMsisdn"=> $request->get('subscriberMsisdn'),
            "pin"=> "2019",
            "orderId"=> $request->get('reference'),
            "description"=> "Paiement affiliation",
            "payToken"=> $mp_token
        ];

        $reponse = procederAuPaiementOm($access_token,$body);

        //dd($body);
        if (isset($reponse->original))
        {
            return response()->json(['status'=>'FAILED','reponse'=>$reponse->original['erreur']]);
        }
        else{
            return response()->json(['status'=>'SUCCESSFULL','reponse'=>$reponse['data']]);
        }

    }

/*     public function omPayementStatusByCustomer(Request $request){
        $payToken = $request->get('payToken');
        $access_token = getOmToken();
        $reponse = statutPaiementOm($access_token,$payToken);
        if (isset($data->reponse)){
            if (isset($status->reponse['data'])){
                if ($reponse['data']['status'] == 'SUCCESSFULL'){
                    return response()->json(['status'=>'SUCCESSFULL','reponse'=>$reponse]);
                }
                elseif ($reponse['data']['status'] == 'PENDING'){
                    return response()->json(['status'=>'PENDING','reponse'=>$reponse]);
                }elseif ($reponse['data']['status'] == 'CANCELLED'){
                    return response()->json(['status'=>'CANCELLED','reponse'=>$reponse]);
                }
            }
            return response()->json(['status'=>'FAILED','reponse'=>$reponse]);
        }else{
            return response()->json(['status'=>'FAILED','reponse'=>$reponse]);
        }
    } */

}
