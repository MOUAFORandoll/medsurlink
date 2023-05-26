<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Message;
use App\Events\MessageCreated;
use Illuminate\Support\Facades\Mail;

class MessageController extends Controller
{
    public function index()
    {
        $messages = Message::with(['user'])->latest()->get();

        return response()->json($messages);
    }
    public function store(Request $request)
    {
        $message = $request->user()->messages()->create([
            'body' => $request->body
        ]);
        broadcast(new MessageCreated($message))
            ->toOthers();
        return response()->json($message);
    }

    public function sendMail(Request $request)
    {
        $userEmail = $request->input('email');
        $subject = $request->input('subject');
        $messageBody = $request->input('message');

        // Envoyer une copie du mail à l'adresse spécifiée
        $ccEmail = 'contrat@medicasure.com';
        Mail::send([], [], function ($message) use ($userEmail, $ccEmail, $subject, $messageBody) {
            $message->to($userEmail)
                ->cc($ccEmail)
                ->subject($subject)
                ->setBody($messageBody);
        });

        return response()->json();
    }

    // Mail::to("contrat@medicasure.com")->later($when, new NouvelAffiliation($user->nom, $user->prenom, $user->telephone, $affiliation->motifs, $request->niveau_urgence, $request->contact_name, $request->contact_firstName, $request->contact_phone, $package->description_fr, $request->paye_par_affilie,$souscripteur,$affiliation, $request->urgence));
}
