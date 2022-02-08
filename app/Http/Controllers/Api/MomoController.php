<?php

namespace App\Http\Controllers\Api;

use App\Models\CodePromo;
use App\Models\ContratIntermediationMedicale;
use App\Models\NotificationPaiement;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Psy\Util\Json;

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

    public function statutPaiementMomo(Request $request){
//            Determination du status du paiement
        $referenceId = $request->get('referenceId');
        $accessToken = $request->get('accessToken');
        $callbackUrl = 'https://www.medicasure.com/'.$request->get('identifiant').'/'.$referenceId.'/collections/callback';

        $paiementStatut = requestToPayStatus($referenceId,'mtncameroon ',$this->subscriptionKey,$accessToken,$callbackUrl);
        if (isset($original->paiementStatut)){
            return response()->json(['statut'=>'FAILED','reason'=>($paiementStatut->original)['erreur']]);
        }else{
            //je vérifis si la transaction à reuissi
            $reponse = json_decode($paiementStatut->getBody()->getContents(),true);

            if ($reponse['status'] == "SUCCESSFUL"){
                $identifiant = $request->get('identifiant');
                $contrat = ContratIntermediationMedicale::where('contrat_code','=',$identifiant)->first();
//                $nbreContrat = ContratIntermediationMedicale::where('emailSouscripteur1','=',$contrat->emailSouscripteur1)->where('statut_paiement','=','PAYÉ')->count();
                $prix=0;
                if( $contrat->montantSouscription == '45.000' ){
                    $prix = 45000;
                }else if( $contrat->montantSouscription == '85'){
                    $prix = 85*655.957;
                }
                else if($contrat->montantSouscription == '25.000'){
                    $prix = 25000;
                }
                else if($contrat->montantSouscription == '50'){
                    $prix = 50*655.957;
                }
                else if($contrat->montantSouscription == '65.000' ){
                    $prix = 65000;
                }
                else if($contrat->montantSouscription == '100'){
                    $prix = 100*655.957;
                }

                if(!is_null($contrat->code_promo) && ($contrat->code_promo!='')){
                    $code = CodePromo::whereCode($contrat->code_promo)->first();
                    if ($code != null){
                        if ($code->reduction != null && $code->reduction != ''){
                            $reduction = ($prix*$code->reduction)/100;
                            $prix = $prix - $reduction;
                        }elseif ($code->prix_final != null && $code->prix_final !=''){
                            $prix = $code->prix_final;
                        }
                    }
                }

//                if (($nbreContrat >0 ) && (($nbreContrat+1) % 3 == 0)){
                $contrat->reduction = 'non';
//                    $prix = ($prix * 0.8); //Obtention réduction de 20%
                $contrat->montantSouscription = $prix;
//                }
                $contrat->statut_paiement = 'PAYÉ';
                $contrat->reference_paiement = $referenceId;
                $contrat->type_paiement = 'MOMO';
                $contrat->date_paiement = Carbon::now()->toDateTimeString();
                $contrat->save();
                return response()->json(['statut'=>"SUCCESSFUL",'success'=>'success du paiement']);
            } else{
                if(isset($raison->paiementStatut)){
                    return response()->json(['statut'=>$reponse['status'],'reason'=>$reponse['reason']]);
                }else{
                    return response()->json(['statut'=>$reponse['status'],'reason'=>$reponse]);
                }
            }
        }

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
            'externalId'=> $request->get('identifiant'),
            "payer"=>[
                "partyIdType"=>"MSISDN",
                "partyId"=>'237'.$request->phone,
            ],
            'payerMessage'=> $request->get('message'),
            'payeeNote' => $request->get('note')
        );

        $referenceId = $request->get('referenceId');

        $operation = json_encode($operation);
        $callbackUrl = '';

        $paiementInformation =  requestToPay($referenceId,'mtncameroon ',$this->subscriptionKey,$accessToken,$operation,$this->host,$callbackUrl);

        if($paiementInformation['responseCode'] == 202) {
            return response()->json(['status'=>'SUCCESSFUL','reponse' => $paiementInformation, 'referenceId' => $referenceId,'accessToken'=>$accessToken]);
        } else{
            return response()->json(['status'=>"FAILED",'reason'=>$paiementInformation['response']]);
        }
    }

    public function momoPayementStatusByCustomer(Request $request){
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
                return response()->json(['status'=>"SUCCESSFUL",'success'=>'success du paiement']);
            } else{
                if(isset($raison->paiementStatut)){
                    return response()->json(['status'=>$reponse['status'],'reason'=>$reponse['reason']]);
                }else{
                    return response()->json(['status'=>$reponse['status'],'reason'=>$reponse]);
                }
            }
        }
    }
}
