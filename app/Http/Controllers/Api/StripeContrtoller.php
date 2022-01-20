<?php

namespace App\Http\Controllers\Api;

use App\Models\CodePromo;
use App\Models\ContratIntermediationMedicale;
use App\Models\NotificationPaiement;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Psy\Util\Json;
use Stripe\Charge;
use Stripe\Checkout\Session;
use Stripe\Stripe;
use Swap\Builder;
use App\Models\CommandePackage;
use App\Models\PaymentOffre;
class StripeContrtoller extends Controller
{
    public function procederAuPaiement(Request $request){
        // $swap = (new Builder())
        //     ->add('fixer', ['access_key' => '6725eecbfab360915787d6dabfc326c9'])
        //     ->add('currency_layer', ['access_key' => '6725eecbfab360915787d6dabfc326c9', 'enterprise' => false])
        //     ->build();
        // $euroFranc = $swap->latest('EUR/XAF')->getValue();
        //Stripe::setApiKey('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');
        Stripe::setApiKey('sk_test_51HfRm5AB7Hl5NGXsFgNP6YeAnDn8W4ieGbRuREW0YU1IJRIXPvlNEDYANGCStZ3KP4aGV5mWewJQevVmdPlPh5RR00FDtdo9q5');

          $commande =  CommandePackage::create([
                "date_commande" => Carbon::now()->toDateTimeString(),
                "montant" =>$request->get('amount'),
                'statut' =>"EN ATTENTE",
                'quantite' =>$request->get('quantite'),
                'offres_packages_id' =>$request->get('package_id'),
                'souscripteur_id' => Auth::id()
            ]);

        //dd( $prixTotal);
        $session =   Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'EUR',
                    'product_data' => [
                        'name' => 'Intermediation médicale',
                    ],
                    'unit_amount' => $request->get('amount'),
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => url('api/paiement/stripe-paiement-success/'.$commande->id),
            'cancel_url' => url($request->get('cancel_url')),
        ]);

        return response()->json([ 'id' => $session->id]);
    }

    public function stripePaidByCustomer(Request $request){
        // $swap = (new Builder())
        //     ->add('fixer', ['access_key' => '6725eecbfab360915787d6dabfc326c9'])
        //     ->add('currency_layer', ['access_key' => '6725eecbfab360915787d6dabfc326c9', 'enterprise' => false])
        //     ->build();
        // $euroFranc = $swap->latest('EUR/XAF')->getValue();
        //Stripe::setApiKey('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');
        Stripe::setApiKey('sk_test_51HfRm5AB7Hl5NGXsFgNP6YeAnDn8W4ieGbRuREW0YU1IJRIXPvlNEDYANGCStZ3KP4aGV5mWewJQevVmdPlPh5RR00FDtdo9q5');
        dd(Auth::id());
        $commande =  CommandePackage::create([
            "date_commande" => Carbon::now()->toDateTimeString(),
            'quantite' =>$request->get('quantite'),
            'offres_packages_id' =>$request->get('package_id'),
            'souscripteur_id' => Auth::id()
        ]);
        $session =   Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'EUR',
                    'product_data' => [
                        'name' => 'Intermediation médicale',
                    ],
                    'unit_amount' => $request->get('amount'),
                ],
                'quantity' =>$request->get('quantite'),
            ]],
            'mode' => 'payment',
            'success_url' => url('api/paiement/stripe-paiement-success/'.$commande->id),
            'cancel_url' => url('api/paiement/stripe-paiement-cancel'),
        ]);
        return response()->json([ 'id' => $session->id]);
    }
    /*public function renouvellementPaiement(Request $request){
        $swap = (new Builder())
            ->add('fixer', ['access_key' => '6725eecbfab360915787d6dabfc326c9'])
            ->add('currency_layer', ['access_key' => '6725eecbfab360915787d6dabfc326c9', 'enterprise' => false])
            ->build();
        $euroFranc = $swap->latest('EUR/XAF')->getValue();

        $identifiant = explode(',',$request->get('identifiant'));
        //Stripe::setApiKey('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');
        Stripe::setApiKey('sk_test_51HfRm5AB7Hl5NGXsFgNP6YeAnDn8W4ieGbRuREW0YU1IJRIXPvlNEDYANGCStZ3KP4aGV5mWewJQevVmdPlPh5RR00FDtdo9q5');

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
    }*/
    public function NotifierPaiement(Request $request,$slug){

            NotificationPaiement::create([
                "type"=>'Stripe',
                "code_contrat"=>$slug,
                "pay_token"=>'',
                "statut"=>'Success',
                "reponse"=>Json::encode($request->all()),
            ]);

            PaymentOffre::create([
                "date_payment" => Carbon::now()->toDateTimeString(),
                "montant" => 0,
                'status' => 'SUCCESS',
                'commande_id' =>$slug,
                'souscripteur_id' => Auth::id()
            ]);
            return response()->json([ 'paiement' => "SUCCESS"]);
    }

}
