<?php

namespace App\Http\Controllers\Api;

use App\Message;
use App\Mail\MessageSend;
use Illuminate\Http\Request;
use App\Events\MessageCreated;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class MessageController extends Controller
{
    public function index(Request $request)
    {
        $size =  $request->page ?? 10;
        $messages = Message::with(['user'])->latest()->paginate($size);
        return $this->successResponse($messages);
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

        $message = Message::create(['uuid' => Str::uuid(), 'creator_id' => auth()->user()->id, 'user_email' => json_encode($request->email),'subject'=> $request->subject, 'message_body' => $request->message]);

        foreach ($request->email as $email) {
            $when = now()->addMinutes(1);
            //Mail::to($email)->cc('contrat@medicasure.com')->send(new MessageSend($email, $request->subject, $request->message));
            Mail::to($email)->cc('contrat@medicasure.com')->later($when, new MessageSend($email, $request->subject, $request->message));
        }
        return $this->successResponse($message);

    }

    // Mail::to("contrat@medicasure.com")->later($when, new NouvelAffiliation($user->nom, $user->prenom, $user->telephone, $affiliation->motifs, $request->niveau_urgence, $request->contact_name, $request->contact_firstName, $request->contact_phone, $package->description_fr, $request->paye_par_affilie,$souscripteur,$affiliation, $request->urgence));
}
