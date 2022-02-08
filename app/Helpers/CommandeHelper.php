<?php

if(!function_exists('enregistrerCommande')) {
    function enregistrerCommande($souscripteur,$commande,$cim_id,$date_paiement)
    {
        $commande =  \App\Models\AffiliationSouscripteur::create([
            'user_id'=>$souscripteur->id,
            'type_contrat'=>$commande->name,
            'nombre_paye'=>$commande->quantity,
            'nombre_restant'=>$commande->quantity,
            'montant'=>$commande->price,
            'cim_id'=>$cim_id,
            'date_paiement'=>$date_paiement ? \Carbon\Carbon::parse($date_paiement)->toDateTimeString() : null
        ]);

        return $commande;
    }
}

if(!function_exists('reduireCommandeRestante')) {
    function reduireCommandeRestante($id)
    {
        $commande =  \App\Models\AffiliationSouscripteur::where("id",$id)->first();

        $commande->nombre_restant-=1;
        $commande->save();

        return $commande;
    }
}
if(!function_exists('increaseCommandeRestante')) {
    function increaseCommandeRestante($id)
    {
        $commande =  \App\Models\AffiliationSouscripteur::where("user_id",$id)->first();

        $commande->nombre_restant+=1;
        $commande->save();

        return $commande;
    }
}
if(!function_exists('resteDeCommande')) {
    function resteDeCommande($souscripteur_id)
    {
        $commande =  \App\Models\AffiliationSouscripteur::where('user_id',$souscripteur_id)->orderBy('created_at', 'desc')->first();

        return $commande;
    }
}

if(!function_exists('peutOnAjouterCommande')) {
    function peutOnAjouterCommande($commande_id)
    {
        $commande =  \App\Models\AffiliationSouscripteur::whereId($commande_id)->first();

        return $commande->nombre_restant > 0;
    }
}

if(!function_exists('laCommandeExisteElle')) {
    function laCommandeExisteElle($commande_id)
    {
        $commande =  \App\Models\AffiliationSouscripteur::where('cim_id','==',$commande_id)->first();

        return $commande != null ;
    }
}


if(!function_exists('transformerCommande')) {
    function transformerCommande($commande,$request,$pays)
    {
        $montant = round($commande->montant / $commande->nombre_paye,2);
        $detailContrat['typeSouscription']=$commande->type_contrat ? $commande->type_contrat:'Annuelle';
        $detailContrat['typeSouscription']='Annuelle';
        $detailContrat['plaintes']=$request->plaintes;
        $detailContrat['urgence']=$request->urgence;
        $detailContrat['nom_pere']=$request->nom_pere;
        $detailContrat['nom_mere']=$request->nom_mere;
        $detailContrat['canal']=$request->canal;
        $detailContrat['dateSignature']=$commande->date_paiement;
        $detailContrat['montantSouscription']=$montant.'';
        $detailContrat['paye_par_affilie']='non';
        $detailContrat['renouvelle']='non';
        $detailContrat['decede']='non';
        $detailContrat['paysSouscription']= $pays == 'Cameroun' ? 'Cameroon' :  $pays;
        $detailContrat['date_paiement']= $commande->date_paiement;

        return $detailContrat;
    }
}
