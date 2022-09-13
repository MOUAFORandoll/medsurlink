<?php

namespace App\Console\Commands;

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
        $affiliations = DB::table('model_changes_history')->where('model_type', 'App\Models\Affiliation')->get(['model_id', 'changer_id']);
        foreach($affiliations as $affiliation){
            
        }
        $this->info($affiliations);
        $this->info("Vos métriques d'aujourd'hui ont été recupérer avec succèes");
    }
}
