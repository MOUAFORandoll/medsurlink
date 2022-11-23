<?php

namespace App\Services;

use App\Mail\AlerteEmail;
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
    public  $user_id;

    public function __construct()
    {
        $this->user_id = \Auth::guard('api')->user()->id;
    }
    public function index(Request $request){
        $alertes = Alerte::with(['patient:id,nom,prenom', 'creator:id,nom,prenom'])->latest()->get();
        return $alertes;
    }

    public function store(Request $request){

        $alerte = Alerte::create(['uuid' => Str::uuid(), 'patient_id' => $request->patient_id, 'niveau_urgence_id' => $request->niveau_urgence_id, 'statut_id' => $request->statut_id, 'creator_id' => $this->user_id, 'plainte' => $request->plainte]);
        $users = User::role('Assistante')->get();

        $alerte = $alerte->load('creator:id,nom,prenom', 'patient:id,nom,prenom');

        Notification::send($users, new AlerteNotification("Nouvelle Alerte", $alerte));
        /* $when = now()->addMinutes(1);
        Mail::to("klfkl@jf.com")->later($when, new AlerteEmail("Nouvelle Alerte", $alerte)); */

        $slack_message = "";
        $slack_message = $slack_message. "Je teste les messages de Slack";

        $env = strtolower(config('app.env'));
        $url_global = "";
        if ($env == 'local')
            $url_global = config('app.url_loccale');
        else if ($env == 'staging')
            $url_global = config('app.url_stagging');
        else
            $url_global = config('app.url_prod');
        $url_global = $url_global."/alertes";

        $slack_message = $slack_message. "<$url_global|Voir plus de détails>";

        $alerte->setSlackChannel('appel')->notify(new SouscriptionAlert($slack_message,null));
        return $alerte;
    }

    public function show($alerte){

        $alerte = Alerte::findOrFail($alerte)->load('patient', 'creator');
        return $alerte;

    }

    public function update(Request $request, $alerte){
        $alerte = Alerte::findOrFail($alerte);
        $alerte->update(['patient_id' => $request->patient_id, 'niveau_urgence_id' => $request->niveau_urgence_id, 'statut_id' => $request->statut_id, 'plainte' => $request->plainte]);
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
