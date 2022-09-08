<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

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
    }
}
