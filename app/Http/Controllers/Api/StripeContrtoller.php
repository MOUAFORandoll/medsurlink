<?php

namespace App\Http\Controllers\Api;

use App\Models\NotificationPaiement;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Psy\Util\Json;
use Stripe\Checkout\Session;
use Stripe\Stripe;

class StripeContrtoller extends Controller
{
    public function procederAuPaiement(Request $request){
        // $swap = (new Builder())
        //     ->add('fixer', ['access_key' => '6725eecbfab360915787d6dabfc326c9'])
        //     ->add('currency_layer', ['access_key' => '6725eecbfab360915787d6dabfc326c9', 'enterprise' => false])
        //     ->build();
        // $euroFranc = $swap->latest('EUR/XAF')->getValue();

        $identifiant = explode(',',$request->get('identifiant'));
        Stripe::setApiKey('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');
        //Stripe::setApiKey('sk_test_51HfRm5AB7Hl5NGXsFgNP6YeAnDn8W4ieGbRuREW0YU1IJRIXPvlNEDYANGCStZ3KP4aGV5mWewJQevVmdPlPh5RR00FDtdo9q5');
        //$contrats = ContratIntermediationMedicale::whereIn('contrat_code',$identifiant)->get();


        $prixTotal=0;


        //dd( $prixTotal);
        $session =   Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'EUR',
                    'product_data' => [
                        'name' => 'Intermediation médicale',
                    ],
                    'unit_amount' => $prixTotal,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => url('api/v1.0.0/stripe-paiement-success/'.$request->get('identifiant')),
            'cancel_url' => url('/affiliation/uba-paiement/error/CANCELED'),
        ]);
        return response()->json([ 'id' => $session->id]);
    }

    public function NotifierPaiement(Request $request,$slug){
        $identifiants = explode(',',$slug);

            NotificationPaiement::create([
                "type"=>'Stripe',
                //"code_contrat"=>$contrat->slug,
                "pay_token"=>'',
                "statut"=>'Success',
                "reponse"=>Json::encode($request->all()),
            ]);

        return redirect(url('/affiliation/uba-paiement/'.$slug.'/SUCCESSFUL'));
    }
}
