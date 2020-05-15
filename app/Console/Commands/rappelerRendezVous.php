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
        $rdvs = RendezVous::with('patient','praticien')
            ->whereDate('date',$dateRendezVous)
            ->where('statut','<>','Annulé')->get();

        foreach ($rdvs as $rdv){
            $date = Carbon::parse($rdv->date)->format('d/m/Y');
            $heure = Carbon::parse($rdv->date)->format('H').'h'.Carbon::parse($rdv->date)->format('i');
            if (!is_null($rdv->nom_medecin)){
                $praticien = $rdv->nom_medecin;
            }else{
                $praticien = $rdv->praticien->nom;
            }
            $this->RappelerRdvViaSMSTo($rdv->patient,$praticien,$date,$heure);
        }

    }
}
