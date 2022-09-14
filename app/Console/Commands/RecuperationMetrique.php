<?php

namespace App\Console\Commands;

use App\Models\Affiliation;
use App\Models\AffiliationSouscripteur;
use App\Models\CommandePackage;
use App\Models\PaymentOffre;
use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class RecuperationMetrique extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'metrique:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Recupération journalière des metriques relatives au calcul des délais de prise en charge";

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $metrique = RecuperationMetrique();
        $histories = DB::table('model_changes_history')->where('model_type', 'App\Models\Affiliation')->get(['model_id', 'changer_id']);
        foreach($histories as $history){
            $user = User::find($history->changer_id);
            if($user->hasRole('Assistante')){
                $affiliation = Affiliation::find($history->model_id);
                /**
                 * Recupération de toute les commandes des utilisateurs dont l'ama à fait l'affiliation
                 */
                $offres_packages_commandes = CommandePackage::whereHas('paymentOffres', function($query){
                    $query->where('status', 'SUCCESS');
                })->where(['souscripteur_id' => $affiliation->souscripteur_id, 'offres_packages_id' => $affiliation->package_id])->get();
                foreach($offres_packages_commandes as $commande){
                    $affiliation_souscripteur = AffiliationSouscripteur::where(['user_id' => $affiliation->souscripteur_id, 'cim_id' => $commande->id])->where('nombre_restant', '>', 0)->first();
                    if(!is_null($affiliation_souscripteur)){
                        $affiliation_souscripteur->nombre_restant -=1;
                        $affiliation_souscripteur->save();
                        $this->info($affiliation_souscripteur);
                    }
                }
            }
        }
        $this->info("Vos métriques d'aujourd'hui ont été recupérer avec succèes");
    }
}
