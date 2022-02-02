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
use App\User;
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
                    'unit_amount' =>(int)$request->get('amount') * 100,
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

        $commande =  CommandePackage::create([
            "date_commande" => Carbon::now()->toDateTimeString(),
            'quantite' =>$request->get('quantite'),
            'offres_packages_id' =>$request->get('package_id'),
            'souscripteur_id' => $request->get('souscripteur_id'),
        ]);
        PaymentOffre::create([
            "date_payment" => Carbon::now()->toDateTimeString(),
            "montant" => $request->get('quantite') * $request->get('amount'),
            'status' => 'EN ATTENTE',
            'commande_id' =>$commande->id,
            'souscripteur_id' => $request->get('souscripteur_id'),
        ]);
        AffiliationSouscripteur::create([
            'user_id'=>$request->get('souscripteur_id'),
            'type_contrat'=>$commande->offres_packages_id,
            'nombre_paye'=>$request->get('quantite'),
            'nombre_restant'=>$request->get('quantite'),
            'montant'=>$request->get('amount'),
            'cim_id'=>$commande->id,
            'date_paiement'=>null,
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
            "montant" => $request->get('quantite') * $request->get('amount'),
            'status' => 'EN ATTENTE',
            'commande_id' =>$commande->id,
            'souscripteur_id' => $souscripteur->user_id,
        ]);
        $affiliation = AffiliationSouscripteur::where("cim_id",$commande->id)->first();
        if($affiliation == null){
            AffiliationSouscripteur::create([
                'user_id'=>$souscripteur->user_id,
                'type_contrat'=>$commande->offres_packages_id,
                'nombre_paye'=>$request->get('quantite'),
                'nombre_restant'=>$request->get('quantite'),
                'montant'=>$request->get('amount'),
                'cim_id'=>$commande->id,
                'date_paiement'=>null,
               ]);
        }else{
            $affiliation->nombre_paye = $request->get('quantite');
            $affiliation->save();
        }
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
                'quantity' =>$request->get('quantite'),
            ]],
            'mode' => 'payment',
            'success_url' => url('api/paiement/stripe-paiement-success/'.$commande->id.'/'.$tokenInfo),
            'cancel_url' => url('api/paiement/stripe-paiement-cancel'),
        ]);


        return response()->json([ 'id' => $session->id,'token'=>$tokenInfo]);
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
    public function NotifierPaiement(Request $request,$slug,$token){

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
           $affiliation = AffiliationSouscripteur::where("cim_id",$slug)->first();
           //dd($affiliation);
           $affiliation->date_paiement = Carbon::now()->toDateTimeString();
           $affiliation->save();
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
    public function notifAndRedirectToAccount(Request $request,$slug){

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
       $affiliation = AffiliationSouscripteur::where("cim_id",$slug)->first();
       $affiliation->date_paiement = Carbon::now()->toDateTimeString();
       $affiliation->save();
       $souscripteur = Souscripteur::with('user')->where('user_id','=',$affiliation->user_id)->first();
       $updatePath = 'token=';
       //$reponse = $token->getOriginalContent()['reponse'];
       $updatePath = 'status=success&'.$updatePath.$souscripteur->user->token;


       $env = strtolower(config('app.env'));
       if ($env === 'local')
       return  redirect('http://localhost:8080/contrat-prepaye/add?'.$updatePath);
       //return redirect('http://localhost:8081/dashboard/user-management/patients/paiement-status/'.$slug);
        else if ($env === 'staging')
            return  redirect('https://www.staging.medsurlink.com/'.$slug);
        else
            return  redirect('https://www.medsurlink.com/'.$slug);
       //return redirect('http://localhost:8081/dashboard/user-management/patients/paiement-status/'.$slug);
}
}
