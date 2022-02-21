<?php

namespace App\Http\Controllers\Api;

use App\Models\CodePromo;
use App\Models\ContratIntermediationMedicale;
use App\Models\NotificationPaiement;
use App\Models\Visiteur;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Psy\Util\Json;

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

    public function procederAuPaiement(Request $request,$identifiant){
        //$identifiant = $request->input('identifiant');
        $subscriberMsisdn = $request->input('subscriberMsisdn');
        $code= explode(',',$identifiant);
        $validator=Validator::make(array('identifiant'=>$code,'subscriberMsisdn'=>$subscriberMsisdn),[
            'subscriberMsisdn'=>'required|digits_between:9,12',
            'identifiant'=>'required|exists:contrat_intermediation_medicales,contrat_code']);
        if ($validator->fails()){
            return response()->json(['error'=>$validator->errors()->getMessages()]);
        }
        $contrat = ContratIntermediationMedicale::where('contrat_code','=',$identifiant)->first();
        $access_token = getOmToken();
        $mp_token = initierPaiement($access_token);
        $body =[
            "notifUrl"=> "https://www.medicasure.com/api/v1.0.0/om/".$identifiant."/".$mp_token."/notification",
            "channelUserMsisdn"=> "658392349",
            "amount"=> $request->get('amount'),
            "subscriberMsisdn"=> $request->get('subscriberMsisdn'),
            "pin"=> "2019",
            "orderId"=> str_replace($identifiant,',','-'),
            "description"=> "",
            "payToken"=> $mp_token
        ];

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

    public function statutPaiementOm(Request $request,$identifiant,$payToken){
        $access_token = getOmToken();
        $reponse = statutPaiementOm($access_token,$payToken);
        if (isset($data->reponse)){
            if (isset($status->reponse['data'])){
                if ($reponse['data']['status'] == 'SUCCESSFULL'){
                    $identifiants = explode(',',$identifiant);
                    $contrats = ContratIntermediationMedicale::whereIn('contrat_code','=',$identifiants)->latest()->get();
//                    $nbreContrat = ContratIntermediationMedicale::where('emailSouscripteur1','=',$contrat->emailSouscripteur1)->where('statut_paiement','=','PAYÉ')->count();
                    foreach($contrats as $contrat){
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

//                    if (($nbreContrat >0 ) && (($nbreContrat+1) % 3 == 0)){
                    $contrat->reduction = 'non';
//                        $prix = ($prix * 0.8); //Obtention réduction de 20%
                    $contrat->montantSouscription = $prix;
//                    }
                    $contrat->statut_paiement = 'PAYÉ';
                    $contrat->type_paiement = 'OM';
                    $contrat->date_paiement = Carbon::now()->toDateTimeString();
                    $contrat->save();
                    }
                    // implementer la redirection vers medsurlink ici
                    // id_contrat,
                    $this->souscripteurRedirectToMedsurlink($contrat->emailSouscripteur1);
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
            "notifUrl"=> "https://www.medicasure.com/api/v1.0.0/om/".$mp_token."/notification",
            "channelUserMsisdn"=> "658392349",
            "amount"=> $request->get('amount'),
            "subscriberMsisdn"=> $request->get('subscriberMsisdn'),
            "pin"=> "2019",
            "orderId"=> $request->get('reference'),
            "description"=> $request->get('description',''),
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

    public function omPayementStatusByCustomer(Request $request){
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
    }

}
