<?php

namespace App\Console\Commands;

use App\Mail\Rappel;
use App\Mail\Rdv\RappelSouscripteur;
use App\Models\Auteur;
use App\Models\RendezVous;
use App\Notifications\SouscriptionAlert;
use App\Services\RendezVousService;
use App\Traits\SmsTrait;
use App\User;
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
         * recupération des rendez vous du module de téléconsultation
         */
        $tomorrow_rendez_vous = new RendezVousService();

        $tomorrow_rdv = $tomorrow_rendez_vous->fetchTomorrowRendezVous();

        foreach($tomorrow_rdv as $_rdv){
            if($_rdv['patient']['user']['decede'] == 'non'){
                $patient = $_rdv['patient']['name'];
                $date_heure = Carbon::parse($_rdv['date'])->format('d-M-Y à H:i');
                $praticien = !is_null($_rdv['creator']) ? $_rdv['medecin'][0]['name'] : "";
                $etablissement = !is_null($_rdv['etablissement_id']) ? $_rdv['etablissement']['name']: null;
                $motif = strip_tags($_rdv['motifs']);
                $slack_notification = "*$patient* a rendez-vous demain le *$date_heure* avec le médecin *$praticien* dans l'établissement *$etablissement*\nMotif: $motif\n\n";

                $env = strtolower(config('app.env'));
                $url_global = "";
                if ($env == 'local')
                    $url_global = config('app.url_loccale');
                else if ($env == 'staging')
                    $url_global = config('app.url_stagging');
                else
                    $url_global = config('app.url_prod');
                $url_global = $url_global."/appointments";

                $slack_notification = $slack_notification. "<$url_global|Voir plus de détails>";
                $_rdvs = RendezVous::first();
                $_rdvs->getSlackChannel()->notify(new SouscriptionAlert($slack_notification,null));
                $patient_phone = $_rdv['patient']['user']['telephone'];
                $medecin_phone = $_rdv['medecin'][0]['user']['telephone'];
                $date = Carbon::parse($_rdv['date'])->format('d/m/Y');
                $heure = Carbon::parse($_rdv['date'])->format('H').'h'.Carbon::parse($_rdv['date'])->format('i');

                $this->RappelRdvViaSMSTo($patient, $patient_phone, $praticien, $medecin_phone, $date, $heure);

                /**  */
                if($_rdv['patient']['souscripteur_id'] !=""){
                    $user = User::find($_rdv['patient']['souscripteur_id']);
                    $mail = new RappelSouscripteur($_rdv['patient']['sexe'], $user->name, $patient, $motif, $_rdv['date'], $etablissement);
                    $when = now()->addMinutes(1);
                    Mail::to($user->email)->later($when, $mail);
                }
            }
        }


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
            ->whereHas('patient', function($query){
                $query->where('decede', 'non');
            })
            ->whereDate('date',$dateRendezVous)
            ->where('statut','<>','Annulé')->orderBy('date', 'asc')->get();
        $slack_notification = "";
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
                $this->RappelerRdvViaSMSTo($rdv->patient,$rdv->praticien,$date,$heure);

                if (is_null($rdv->nom_medecin)) {
                    $mail = new Rappel($rdv);
                    if($rdv->praticien){
                        $when = now()->addMinutes(1);
                        Mail::to($rdv->praticien->email)->later($when,$mail);
                    }
                }
                $patient = mb_strtoupper($rdv->patient->nom).' '.ucfirst($rdv->patient->prenom);
                $date_heure = Carbon::parse($rdv->date)->format('d-M-Y à H:i');
                $docta =  !is_null($rdv->praticien) ? mb_strtoupper($rdv->praticien->nom).' '.ucfirst($rdv->praticien->prenom) : null;
                $praticien = !is_null($rdv->nom_medecin) ? $rdv->nom_medecin : $docta;
                $etablissement = !is_null($rdv->etablissement) ? $rdv->etablissement->name: null;
                $slack_notification = $slack_notification. "*$patient* a rendez-vous demain le *$date_heure* avec le médecin *$praticien* dans l'établissement *$etablissement*\nMotif: $rdv->motifs\n\n";
            }
        }

        $env = strtolower(config('app.env'));
        $url_global = "";
        if ($env == 'local')
            $url_global = config('app.url_loccale');
        else if ($env == 'staging')
            $url_global = config('app.url_stagging');
        else
            $url_global = config('app.url_prod');
        $url_global = $url_global."/appointments";

        $slack_notification = $slack_notification. "<$url_global|Voir plus de détails>";
        if (isset($rdv)){
            $rdv->getSlackChannel()->notify(new SouscriptionAlert($slack_notification,null));
        }

        foreach ($rdvs as $rdv){
            if($rdv->patient->decede == 'non') {
                $souscripteur = $rdv->patient->patient->souscripteur;
                if (!is_null($souscripteur)) {

                    $sexe = $souscripteur->sexe;
                    $name_souscripteur = $souscripteur->user->name;
                    $name_patient = $rdv->patient->name;
                    $date = $rdv->date;
                    $motif = $rdv->motifs;
                    $etablissement = $rdv->etablissement->name;

                    $mail = new RappelSouscripteur($sexe, $name_souscripteur, $name_patient, $motif, $date, $etablissement);
                    $when = now()->addMinutes(1);
                    Mail::to($souscripteur->user->email)->later($when, $mail);
                    //Log::info('envoi de mail de rappel au souscripteur' . $souscripteur->user->email);
                }
                $financeurs = $rdv->patient->patient->financeurs;
                foreach ($financeurs as $financeur) {
                    if($financeur->financable->user){
                        $sexe = $souscripteur->sexe;
                        $name_souscripteur = $financeur->financable->user->name;
                        $name_patient = $rdv->patient->name;
                        $date = $rdv->date;
                        $motif = $rdv->motifs;
                        $etablissement = $rdv->etablissement->name;
                        $mail = new RappelSouscripteur($sexe, $name_souscripteur, $name_patient, $motif, $date, $etablissement);
                        $when = now()->addMinutes(1);
                        Mail::to($financeur->financable->user->email)->later($when, $mail);
                        //Log::info('envoi de mail de rappel au souscripteur' . $financeur->financable->user->email);
                    }
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
