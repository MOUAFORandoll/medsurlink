<?php

namespace App\Services;

use App\Events\AlerteEvent;
use App\Models\Alerte;
use App\Notifications\AlerteNotification;
use App\Notifications\SouscriptionAlert;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;

class AlerteService
{
    public  $user_id, $statut, $niveau_urgence;

    public function __construct()
    {
        $this->statut = new StatutService;
        $this->niveau_urgence = new NiveauUrgenceService;
        $this->user_id = \Auth::guard('api')->user()->id;
    }
    public function index(Request $request){
        $size = $request->size ? $request->size : 10;
        $alertes = Alerte::with(['patient:id,nom,prenom', 'creator:id,nom,prenom']);
        if($request->search != ""){
            $value = $request->search;
            $alertes = $alertes->whereHas('patient', function($q) use ($value) {
                $q->where('nom', 'like', '%' .$value.'%')
                ->orwhere('prenom', 'like', '%' .$value.'%')
                ->orwhere('email', 'like', '%' .$value.'%');
            });
        }
        if($request->statut_id != ""){
            $alertes = $alertes->where('statut_id', $request->statut_id);
        }

        $alertes = $alertes->latest()->paginate($size);

        $items = [];
        foreach($alertes->items() as $item){
            $item->statut = json_decode($this->statut->fetchStatut($item->statut_id), true)['data'];
            $item->niveau_urgence = json_decode($this->niveau_urgence->fetchNiveauUrgence($item->niveau_urgence_id), true)['data'];
            $items[] = $item;
        }
        $alertes->data = $items;

        return $alertes;
    }

    public function store(Request $request){

        $alerte = Alerte::create(['uuid' => Str::uuid(), 'patient_id' => $request->patient_id, 'niveau_urgence_id' => $request->niveau_urgence_id, 'statut_id' => $request->statut_id ?? 1, 'creator_id' => $this->user_id, 'plainte' => $request->plainte]);
        $users = User::role('Assistante')->get();

        $alerte = $alerte->load('creator:id,nom,prenom', 'patient:id,nom,prenom');


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
        $url_global = $url_global."/alertes";

        $slack_message = $slack_message. " <$url_global|En savoir plus>";

        $alerte->setSlackChannel('appel')->notify(new SouscriptionAlert($slack_message,null));
        return $alerte;
    }

    public function show($alerte){

        $user = \Auth::guard('api')->user();
        $user->unreadNotifications()->where('data->uuid', $alerte)->update(['read_at' => now()]);
        $alerte = Alerte::whereId($alerte)->orWhere('uuid', $alerte)->firstOrFail()->load('creator:id,nom,prenom,email,telephone', 'patient:id,nom,prenom,email,telephone', 'patient.patient:user_id,sexe,date_de_naissance');
        $alerte->statut = json_decode($this->statut->fetchStatut($alerte->statut_id), true)['data'];
       
        return $alerte;

    }

    public function update(Request $request, $alerte){
        $alerte = Alerte::findOrFail($alerte);
        $alerte->update(['patient_id' => $request->patient_id, 'niveau_urgence_id' => $request->niveau_urgence_id, 'statut_id' => $request->statut_id, 'plainte' => $request->plainte]);
        return $alerte;

    }

    public function ChangeStatus(Request $request, $alerte){
        $alerte = Alerte::findOrFail($alerte);
        $alerte->statut_id = $request->statut_id;
        $alerte->save();
        return $alerte;
    }

    public function assignMedecin(Request $request, $alerte){
        $alerte = Alerte::findOrFail($alerte);
        $alerte->medecin_id = $request->medecin_id;
        $alerte->statut_id = 2;
        $alerte->save();
        event(new AlerteEvent($alerte, "update_alerte"));

        $user = User::findOrFail($request->medecin_id);
        $user->notify(new AlerteNotification("Nouvelle Alerte", $alerte));
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
