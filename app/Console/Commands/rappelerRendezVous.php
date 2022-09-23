<?php

namespace App\Console\Commands;

use App\Mail\Rappel;
use App\Mail\Rdv\RappelSouscripteur;
use App\Models\Auteur;
use App\Models\RendezVous;
use App\Traits\SmsTrait;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
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
        /**
         * Marqué les rendez-vous non honoré comme manqués
         */

        $aujourdhui = Carbon::now()->format('Y-m-d');
        $rendez_vous = RendezVous::where(function ($query) {
            $query->where('statut', "Programmé")->orWhere('statut', "Reprogrammé");
        })->whereDate('date', '<', $aujourdhui)->get();

        foreach($rendez_vous as $rdv){
            $rdv->statut = "Manqué";
            $rdv->save();
        }

        /**
         * Rappeler le praticien, souscripteur dont  le patient a un rendez-vous demain
         */
        $dateRendezVous = Carbon::tomorrow()->toDateString();
        $rdvs = RendezVous::with('patient','praticien')
            ->whereDate('date',$dateRendezVous)
            ->where('statut','<>','Annulé')->latest()->get();

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

            if($rdv->patient->decede == 'non'){
                $this->RappelerRdvViaSMSTo($rdv->patient,$praticien,$date,$heure);

                if (is_null($rdv->nom_medecin)) {
                    $mail = new Rappel($rdv);
                    Mail::to($rdv->praticien->email)->send($mail);
                }
            }
        }

        foreach ($rdvs as $rdv){
            if($rdv->patient->decede == 'non') {
                $souscripteur = $rdv->patient->patient->souscripteur;
                if (!is_null($souscripteur)) {
                    $mail = new RappelSouscripteur($rdv, $souscripteur);
                    Mail::to($souscripteur->user->email)->send($mail);
                    Log::info('envoi de mail de rappel au souscripteur' . $souscripteur->user->email);
                }
                $financeurs = $rdv->patient->patient->financeurs;
                foreach ($financeurs as $financeur) {
                    $mail = new RappelSouscripteur($rdv, $financeur->financable);
                    Mail::to($financeur->financable->user->email)->send($mail);
                    Log::info('envoi de mail de rappel au souscripteur' . $financeur->financable->user->email);
                }
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
