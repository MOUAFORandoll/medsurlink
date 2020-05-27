<?php

namespace App\Console\Commands;

use App\Mail\Rappel;
use App\Models\Auteur;
use App\Models\RendezVous;
use App\Traits\SmsTrait;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

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
                if (!is_null($rdv->praticien)){
                    $praticien = $rdv->praticien->nom;
                }else{
                    $praticien ='';
                }
            }
            $this->RappelerRdvViaSMSTo($rdv->patient,$praticien,$date,$heure);

            if (is_null($rdv->nom_medecin)) {
                $mail = new Rappel($rdv);
                Mail::to($rdv->praticien->email)->send($mail);
            }
        }
        Auteur::create([
            'user_id'=>1,
            'auteurable_type'=>'Admin',
            'operationable_type'=>'Admin',
            'action'=>'send rappel rdv'
        ]);
    }
}
