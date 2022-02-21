<?php

namespace App\Http\Controllers\Api;

use App\Models\CodePromo;
use App\Models\ContratIntermediationMedicale;
use App\Models\NotificationPaiement;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Psy\Util\Json;


class UbaController extends Controller
{
    public function reponseRequetePaiement(Request $request,$code){

        $ref=$request->query->get('Ref');
        $base_uri = 'https://cm.instantbillspay.com/api/bill/refstatus?ref='.$ref;
        try {
            $client = new Client(['base_uri' => $base_uri]);
            $request = new \GuzzleHttp\Psr7\Request('GET',$base_uri);
            $response = $client->send($request);
            $reponseArray = json_decode($response->getBody()->getContents(),true);
            $status = $reponseArray['Response']['status'];
            if ($status == 'SUCCESSFUL'){
                NotificationPaiement::create([
                    "type"=>'UBA',
                    "code_contrat"=>$code,
                    "pay_token"=>$ref,
                    "statut"=>$status,
                    "reponse"=>json_decode($response->getBody()->getContents(),true),
                ]);
                $identifiant = explode(',',$request->get('identifiant'));
                $contrats = ContratIntermediationMedicale::whereIn('contrat_code','=',$identifiant)->first();
                $nbreContrat = ContratIntermediationMedicale::where('emailSouscripteur1','=',$contrat->emailSouscripteur1)->where('statut_paiement','=','PAYÉ')->count();
               
                $prixTotal=0;
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
                    $prixTotal +=$prix;
                }
       
//                if (($nbreContrat >0 ) && (($nbreContrat+1) % 3 == 0)){
                    $contrat->reduction = 'non';
//                    $prix = ($prix * 0.8); //Obtention réduction de 20%
                    $contrat->montantSouscription = $prix;
//                }
                $contrat->statut_paiement = 'PAYÉ';
                $contrat->type_paiement = 'UBA';
                $contrat->save();
            }
//            dd($request->path());
            Log::info('Ref=>'.$ref);
            return redirect('affiliation/uba-paiement/'.$code.'/'.$status);

        }catch (Exception $exception){
            return response()->json(['erreur'=>$exception->getMessage()],419);
        }

        return view('Paiement.uba');
    }
}
