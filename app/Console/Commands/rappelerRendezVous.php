<?php

namespace App\Console\Commands;

use App\Models\RendezVous;
use App\Traits\SmsTrait;
use Carbon\Carbon;
use Illuminate\Console\Command;

class rappelerRendezVous extends Command
{
    use SmsTrait;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sms:rappelez-rdv';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Rappelez les rendez vous';

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
        $dateRendezVous = Carbon::tomorrow()->toDateString();
        $rdvs = RendezVous::with('patient')
            ->whereDate('date',$dateRendezVous)
            ->where('statut','<>','Annulé')->get();

        $personnesARappeler = $rdvs->pluck('patient');

        foreach ($personnesARappeler as $user){
            $this->RappelerRdvViaSMSTo($user,$dateRendezVous);
        }

    }
}
