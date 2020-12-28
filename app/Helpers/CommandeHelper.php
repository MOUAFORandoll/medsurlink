<?php

if(!function_exists('enregistrerCommande')) {
    function enregistrerCommande($souscripteur,$commande,$cim_id)
    {
        $commande =  \App\Models\AffiliationSouscripteur::create([
            'user_id'=>$souscripteur->id,
            'type_contrat'=>$commande->name,
            'nombre_paye'=>$commande->quantity,
            'nombre_restant'=>$commande->quantity,
            'montant'=>$commande->price,
            'cim_id'=>$cim_id
        ]);

        return $commande;
    }
}

if(!function_exists('reduireCommandeRestante')) {
    function reduireCommandeRestante($commande_id)
    {
        $commande =  \App\Models\AffiliationSouscripteur::whereId($commande_id)->first();

        $commande->nombre_restant-=1;
        $commande->save();

        return $commande;
    }
}

if(!function_exists('resteDeCommande')) {
    function resteDeCommande($souscripteur_id)
    {
        $commande =  \App\Models\AffiliationSouscripteur::where('user_id',$souscripteur_id)->get();

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
        $detailContrat['typeSouscription']=$commande->type_contrat ? $commande->type_contrat:'Annuelle';
        $detailContrat['typeSouscription']='Annuelle';
        $detailContrat['plaintes']=$request->plaintes;
        $detailContrat['urgence']=$request->urgence;
        $detailContrat['nom_pere']=$request->nom_pere;
        $detailContrat['nom_mere']=$request->nom_mere;
        $detailContrat['canal']=$request->canal;
        $detailContrat['dateSignature']=$request->date_signature;
        $detailContrat['montantSouscription']=$request->montant_souscription;
        $detailContrat['paye_par_affilie']='non';
        $detailContrat['renouvelle']='non';
        $detailContrat['decede']='non';
        $detailContrat['paysSouscription']= $pays == 'Cameroun' ? 'Cameroon' :  $pays;

        return $detailContrat;
    }
}
