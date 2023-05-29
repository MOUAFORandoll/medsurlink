<?php

namespace App\Http\Controllers\Api;

use App\Message;
use App\Mail\MessageSend;
use Illuminate\Http\Request;
use App\Events\MessageCreated;
use App\Http\Controllers\Controller;
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
        $this->validate($request, [
            "email" => "required|array",
            "subject" => "required",
            "message" => "required"
        ]);

        foreach ($request->email as $email) {
            Mail::to($email)->cc('contrat@medicasure.com')->send(new MessageSend($email, $request->subject, $request->message));
        }

        return response()->json(['message' => 'Mail envoyé avec succes']);
    }

    // Mail::to("contrat@medicasure.com")->later($when, new NouvelAffiliation($user->nom, $user->prenom, $user->telephone, $affiliation->motifs, $request->niveau_urgence, $request->contact_name, $request->contact_firstName, $request->contact_phone, $package->description_fr, $request->paye_par_affilie,$souscripteur,$affiliation, $request->urgence));
}
