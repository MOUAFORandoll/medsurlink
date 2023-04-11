<?php

namespace App\Services;

use App\Events\AlerteEvent;
use App\Models\Alerte;
use App\Notifications\AlerteNotification;
use App\Notifications\SouscriptionAlert;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;

class AlerteService
{
    public  $user_id, $statut, $niveau_urgence, $user, $teleconsultation;

    public function __construct()
    {
        $this->statut = new StatutService;
        $this->teleconsultation = new TeleconsultationService;
        $this->niveau_urgence = new NiveauUrgenceService;
        if(\Auth::guard('api')->user()){
            $this->user_id = \Auth::guard('api')->user()->id;
            $this->user = \Auth::guard('api')->user();
        }
    }
    public function index(Request $request){
        $size = $request->size ? $request->size : 10;

        $alertes = Alerte::with(['creator:id,nom,prenom,email,telephone', 'patient:id,nom,prenom,email,telephone,slug', 'patient.dossier:patient_id,slug', 'patient.patient:user_id,sexe,date_de_naissance,slug', 'medecin:id,nom,prenom,email,telephone,slug']);
        if($this->user->hasRole('Patient')){
            $alertes = $alertes->where(['patient_id' => $this->user_id, 'creator_id' => $this->user_id]);
        }elseif($this->user->hasRole('Souscripteur')){
            $alertes = $alertes->where('creator_id', $this->user_id);
        }elseif($this->user->hasRole('Medecin controle')){
            //$alertes = $alertes->where('medecin_id', $this->user_id);
        }elseif($this->user->hasRole('Assistante')){

        }
        if($request->search != ""){
            $value = strtolower($request->search);
            $alertes = $alertes->whereHas('patient', function($q) use ($value) {
                $q->where(DB::raw("lower(nom)"), 'like', '%' .$value.'%')
                    ->orwhere(DB::raw("lower(prenom)"), 'like', '%' .$value.'%')
                    ->orwhere(DB::raw("lower(email)"), 'like', '%' .$value.'%')
                    ->orwhere(DB::raw('CONCAT_WS(" ", nom, prenom)'), 'like',  '%'.$value.'%')
                    ->orwhere(DB::raw('CONCAT_WS(" ", prenom, nom)'), 'like',  '%'.$value.'%');
            })->orWhere('plainte', 'like', '%' .$value.'%');
        }
        if($request->statut_id != ""){
            $alertes = $alertes->where('statut_id', $request->statut_id);
        }

        $alertes = $alertes->latest()->paginate($size);

        $items = [];
        $statuts = collect(json_decode($this->statut->fetchStatuts($request), true)['data']);
        $niveau_urgences = collect(json_decode($this->niveau_urgence->fetchNiveauUrgences($request), true)['data']);

        foreach($alertes->items() as $item){

            /**
             * ici nous changeons le statut de l'alerte lorsque la téléconsultation a eu lieu
             */
            if($item->statut_id == 3){
                $item->statut = $statuts->where('id', $item->statut_id)->first();
            }else{
                $tele = null;
                if($item->medecin_id != null){
                    $tele = json_decode($this->teleconsultation->searchTeleconsultation($item->patient_id, $item->medecin_id, $item->created_at->format('Y-m-d')));
                }
                if($tele){
                    $alerte = Alerte::find($item->id);
                    $alerte->statut_id = 3;
                    $alerte->teleconsultation_id = $tele->id;
                    $alerte->save();
                    $item->statut = $statuts->where('id', 3)->first();
                }else{
                    $item->statut = $statuts->where('id', $item->statut_id)->first();
                }
            }
            $item->niveau_urgence = $niveau_urgences->where('id', $item->niveau_urgence_id)->first();
            $items[] = $item;
        }
        $alertes->data = $items;

        return $alertes;
    }

    public function store(Request $request){

        $alerte = Alerte::create(['uuid' => Str::uuid(), 'patient_id' => $request->patient_id, 'niveau_urgence_id' => $request->niveau_urgence_id, 'statut_id' => $request->statut_id ?? 1, 'creator_id' => $request->creator_id ?? $this->user_id, 'plainte' => $request->plainte]);
        $users = User::role('Assistante')->get();

        if(!is_null($request->audio)){
            $alerte->addMedia($request->audio)->toMediaCollection('audio');
            $alerte = $alerte->fresh();
        }

        $alerte = $alerte->load('creator:id,nom,prenom', 'patient:id,nom,prenom,telephone');


        event(new AlerteEvent($alerte));

        Notification::send($users, new AlerteNotification("Nouvelle Alerte", $alerte));


        /* $when = now()->addMinutes(1);
        Mail::to("klfkl@jf.com")->later($when, new AlerteEmail("Nouvelle Alerte", $alerte)); */
        $patient = $alerte->patient->name;
        $creator = $alerte->creator->name;
        $slack_message = "*$creator* a ajouté une nouvelle alerte";
        if($alerte->patient->id != $alerte->creator->id){
            $slack_message = $slack_message." pour le patient *$patient*";
        }
        $slack_message = $slack_message. "\n*Plainte*: $alerte->plainte";


        $env = strtolower(config('app.env'));
        $url_global = "";
        if ($env == 'local')
            $url_global = config('app.url_loccale');
        else if ($env == 'staging')
            $url_global = config('app.url_stagging');
        else
            $url_global = config('app.url_prod');
        $url_global = $url_global."/alertes?uuid=".$alerte->uuid;

        $slack_message = $slack_message. " <$url_global|En savoir plus>";

        $alerte->getSlackChannel()->notify(new SouscriptionAlert($slack_message,null));

        $alerte = $alerte->load('creator:id,nom,prenom,email,telephone', 'patient:id,nom,prenom,email,telephone,slug', 'patient.dossier:patient_id,slug', 'patient.patient:user_id,sexe,date_de_naissance,slug', 'medecin:id,nom,prenom,email,telephone,slug');
        $alerte->statut = json_decode($this->statut->fetchStatut($alerte->statut_id), true)['data'];
        $alerte->niveau_urgence = json_decode($this->niveau_urgence->fetchNiveauUrgence($alerte->niveau_urgence_id), true)['data'];
        return $alerte;
    }

    public function show($alerte){

        $user = \Auth::guard('api')->user();
        $user->unreadNotifications()->where('data->id', $alerte)->orWhere('data->uuid', $alerte)->update(['read_at' => now()]);
        $alerte = Alerte::whereId($alerte)->orWhere('uuid', $alerte)->latest()->firstOrFail()->load('creator:id,nom,prenom,email,telephone', 'patient:id,nom,prenom,email,telephone,slug', 'patient.dossier:patient_id,slug', 'patient.patient:user_id,sexe,date_de_naissance,slug', 'medecin:id,nom,prenom,email,telephone,slug');
        $alerte->statut = json_decode($this->statut->fetchStatut($alerte->statut_id), true)['data'];
        $alerte->niveau_urgence = json_decode($this->niveau_urgence->fetchNiveauUrgence($alerte->niveau_urgence_id), true)['data'];

        return $alerte;

    }

    public function getAlerte($teleconsultation_id){
        $alerte = Alerte::where('teleconsultation_id', $teleconsultation_id)->first();
        return $alerte;
    }



    public function update(Request $request, $alerte){
        $alerte = Alerte::findOrFail($alerte);
        $alerte->patient_id = $request->patient_id;
        $alerte->niveau_urgence_id = $request->niveau_urgence_id;
        $alerte->plainte = $request->plainte;
        $alerte->creator_id = $request->creator_id ?? $this->user_id;

        $alerte->save();

        if(!is_null($request->audio)){
            if($alerte->getMedia('audio')->count() > 0){
                //$alerte->clearMediaCollection('audio');
                $alerte->addMedia($request->audio)->toMediaCollection('audio1');
            }else{
                $alerte->addMedia($request->audio)->toMediaCollection('audio');
            }
            $alerte = $alerte->fresh();
        }

        $alerte = $alerte->load('creator:id,nom,prenom,email,telephone', 'patient:id,nom,prenom,email,telephone,slug', 'patient.dossier:patient_id,slug', 'patient.patient:user_id,sexe,date_de_naissance,slug', 'medecin:id,nom,prenom,email,telephone,slug');
        $alerte->statut = json_decode($this->statut->fetchStatut($alerte->statut_id), true)['data'];
        $alerte->niveau_urgence = json_decode($this->niveau_urgence->fetchNiveauUrgence($alerte->niveau_urgence_id), true)['data'];
        return $alerte;

    }

    public function ChangeStatus(Request $request, $alerte){
        $alerte = Alerte::findOrFail($alerte);
        $alerte->statut_id = $request->statut_id;
        $alerte->save();
        $alerte = $alerte->load('creator:id,nom,prenom,email,telephone', 'patient:id,nom,prenom,email,telephone,slug', 'patient.dossier:patient_id,slug', 'patient.patient:user_id,sexe,date_de_naissance,slug', 'medecin:id,nom,prenom,email,telephone,slug');
        $alerte->statut = json_decode($this->statut->fetchStatut($alerte->statut_id), true)['data'];
        $alerte->niveau_urgence = json_decode($this->niveau_urgence->fetchNiveauUrgence($alerte->niveau_urgence_id), true)['data'];
        return $alerte;
    }

    public function assignMedecin(Request $request, $alerte){
        $alerte = Alerte::findOrFail($alerte);
        $alerte->medecin_id = $request->medecin_id;
        $alerte->statut_id = 2;
        $alerte->save();
        $alerte = $alerte->load('creator:id,nom,prenom', 'patient:id,nom,prenom,telephone');
        event(new AlerteEvent($alerte, "update_alerte"));

        $user = User::findOrFail($request->medecin_id);
        $user->notify(new AlerteNotification("Nouvelle Alerte", $alerte));
        $alerte = $alerte->load('creator:id,nom,prenom,email,telephone', 'patient:id,nom,prenom,email,telephone,slug', 'patient.dossier:patient_id,slug', 'patient.patient:user_id,sexe,date_de_naissance,slug', 'medecin:id,nom,prenom,email,telephone,slug');
        $alerte->statut = json_decode($this->statut->fetchStatut($alerte->statut_id), true)['data'];
        $alerte->niveau_urgence = json_decode($this->niveau_urgence->fetchNiveauUrgence($alerte->niveau_urgence_id), true)['data'];
        return $alerte;
    }

    public function destroy($alerte){

        $alerte = Alerte::findOrFail($alerte);
        $alerte->delete();
        return $alerte;

    }

    public function notifications(){

    }

}
