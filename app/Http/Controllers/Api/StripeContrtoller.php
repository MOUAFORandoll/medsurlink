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
use App\Models\Souscripteur;
use App\Models\AffiliationSouscripteur;
use App\Models\Affiliation;
use App\User;
class StripeContrtoller extends Controller
{
    public $url_loccale= "http://localhost:8080", $url_stagging= "https://www.staging.medsurlink.com", $url_prod= "https://www.medsurlink.com",  $url_global= "";

    public function __construct()
    {
        $env = strtolower(config('app.env'));
        if ($env == 'local')
            $this->url_global = $this->url_loccale;
        else if ($env == 'staging')
            $this->url_global = $this->url_stagging;
        else
            $this->url_global = $this->url_prod;
    }

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
                    'unit_amount' =>(int)$request->get('amount') * 100,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => url('api/paiement/stripe-paiement-success-return/'.$commande->id),
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

        $commande =  CommandePackage::create([
            "date_commande" => Carbon::now()->toDateTimeString(),
            'quantite' =>$request->get('quantite'),
            'offres_packages_id' =>$request->get('package_id'),
            'souscripteur_id' => $request->get('souscripteur_id'),
        ]);
        PaymentOffre::create([
            "date_payment" => Carbon::now()->toDateTimeString(),
            "montant" =>  $request->get('amount'),
            'status' => 'EN ATTENTE',
            'commande_id' =>$commande->id,
            'souscripteur_id' => $request->get('souscripteur_id'),
        ]);

        $session =   Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'EUR',
                    'product_data' => [
                        'name' => 'Intermediation médicale',
                    ],
                    'unit_amount' => (int)$request->get('amount')*100,
                ],
                'quantity' =>1,
            ]],
            'mode' => 'payment',
            'success_url' => url('api/paiement/stripe-paiement-success-return/'.$commande->id),
            'cancel_url' => url('api/paiement/stripe-paiement-cancel'),
        ]);
        return response()->json([ 'id' => $session->id]);
    }
    public function paiementFromMedicasure(Request $request){
        // $swap = (new Builder())
        //     ->add('fixer', ['access_key' => '6725eecbfab360915787d6dabfc326c9'])
        //     ->add('currency_layer', ['access_key' => '6725eecbfab360915787d6dabfc326c9', 'enterprise' => false])
        //     ->build();
        // $euroFranc = $swap->latest('EUR/XAF')->getValue();
        //Stripe::setApiKey('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');
        Stripe::setApiKey('sk_test_51HfRm5AB7Hl5NGXsFgNP6YeAnDn8W4ieGbRuREW0YU1IJRIXPvlNEDYANGCStZ3KP4aGV5mWewJQevVmdPlPh5RR00FDtdo9q5');
        //dd($request);
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

        $session =   Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'EUR',
                    'product_data' => [
                        'name' => 'Intermediation médicale',
                    ],
                    'unit_amount' => (int)$request->get('amount')*100,
                ],
                'quantity' =>1,
            ]],
            'mode' => 'payment',
            'success_url' => url('api/paiement/stripe-paiement-success/'.$commande->id.'/'.$tokenInfo),
            'cancel_url' => url('api/paiement/stripe-paiement-cancel'),
        ]);


        return response()->json([ 'id' => $session->id,'token'=>$tokenInfo]);
    }
    public function renouvellementPaiement(Request $request){

        //Stripe::setApiKey('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');
        Stripe::setApiKey('sk_test_51HfRm5AB7Hl5NGXsFgNP6YeAnDn8W4ieGbRuREW0YU1IJRIXPvlNEDYANGCStZ3KP4aGV5mWewJQevVmdPlPh5RR00FDtdo9q5');

        $commande =  CommandePackage::create([
            "date_commande" => Carbon::now()->toDateTimeString(),
            'quantite' =>1,
            'offres_packages_id' =>$request->get('package_id'),
            'souscripteur_id' => $request->get('souscripteur_id'),
        ]);
        PaymentOffre::create([
            "date_payment" => Carbon::now()->toDateTimeString(),
            "montant" =>  $request->get('amount'),
            'status' => 'RENOUVELLEMENT',
            'commande_id' => $commande->id,
            'souscripteur_id' => $request->get('souscripteur_id'),
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
                    'unit_amount' => (int)$request->get('amount')*100,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => url('api/paiement/stripe-renew-success/'.$commande->id.'/'.$request->get('patient_id')),
            'cancel_url' => url('/affiliation/uba-paiement/error/CANCELED'),
        ]);
        return response()->json([ 'id' => $session->id]);
    }
    public function NotifierPaiement(Request $request,$slug,$token){

            $this->UpdateAndSendEmailAfterPayment($request, $slug);
            $updatePath = $token == "checkout" ? 'success' : 'contrat-prepaye/add?status=success&token='.$token;

           return redirect($this->url_global.'/'.$updatePath);

    }
    public function notifAndRedirectToAccount(Request $request,$slug){

       $this->UpdateAndSendEmailAfterPayment($request, $slug);

       return redirect($this->url_global.'/dashboard/user-management/patients/paiement-status/'.$slug);

    }

    public function notifRenewAndRedirectToAccount(Request $request, $slug, $patient){

        $slug = $this->UpdateAndSendEmailAfterPayment($request, $slug, $patient);

        return redirect($this->url_global.'/affiliation/'.$slug.'?renouvellement=success');
    }

    public function notifExtraAndRedirectToAccount(Request $request,$slug,$patient){


       $slug = $this->UpdateAndSendEmailAfterPayment($request, $slug, $patient);
       return redirect($this->url_global.'/affiliation/'.$slug.'?renouvellement=success');
    }

    public function UpdateAndSendEmailAfterPayment(Request $request, $slug, $patient = null){
        /**
         * Notification après le paiement
         */
        NotificationPaiement::create([
            "type"=>'Stripe',
            "code_contrat"=>$slug,
            "pay_token"=>'',
            "statut"=>'Success',
            "reponse"=>Json::encode($request->all()),
        ]);

       $payment = PaymentOffre::where("commande_id",$slug)->first();
       $payment->status = "SUCCESS";
       $payment->save();
       if(!is_null($patient)){
            return ProcessAfterPayment($payment, $patient);
        }else{
            ProcessAfterPayment($payment, $patient);
        }
    }
}
