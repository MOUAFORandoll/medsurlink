<?php

namespace App\Jobs;

use App\Mail\Rdv\RappelSouscripteur;
use App\Models\RendezVous;
use App\Traits\SmsTrait;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class RappelRendezVous implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    use SmsTrait;

    protected $personnesARappeler;
    protected $dateRendezVous;
    protected $rdvs;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->dateRendezVous = Carbon::tomorrow()->toDateString();
        $rdvs = RendezVous::with('patient')
                ->whereDate('date',$this->dateRendezVous)->get();
        $this->rdvs = $rdvs;
        $this->personnesARappeler = $rdvs->pluck('patient');
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->personnesARappeler as $user){
            if (!is_null($user)){
                $this->RappelerRdvViaSMSTo($user,$this->dateRendezVous);
            }
        }
        foreach ($this->rdvs as $rdv){
            $souscripteur = $rdv->patient->patient->souscripteur;
            if (!is_null($souscripteur)){
                $mail = new RappelSouscripteur($rdv,$souscripteur);
                Mail::to($souscripteur->user->email)->send($mail);
                Log::info('envoi de mail de rappel au souscripteur'.$souscripteur->user->email);
            }
            $financeurs = $rdv->patient->patient->financeurs;
            foreach ($financeurs as $financeur){
                $mail = new RappelSouscripteur($rdv,$financeur->financable);
                Mail::to($financeur->financable->user->email)->send($mail);
                Log::info('envoi de mail de rappel au souscripteur'.$financeur->financable->user->email);
            }
        }
    }
}
