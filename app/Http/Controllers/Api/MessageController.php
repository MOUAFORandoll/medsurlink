<?php

namespace App\Http\Controllers\Api;

use App\Message;
use App\Mail\MessageSend;
use Illuminate\Http\Request;
use App\Events\MessageCreated;
use App\Http\Controllers\Controller;
use App\Models\Role;
use App\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class MessageController extends Controller
{
    public function index(Request $request)
    {
        $size =  $request->page_size ?? 10;
        $messages = Message::with(['user:id,nom,prenom,email,telephone'])->withCount(['groupes', 'users', 'roles'])->latest()->paginate($size);
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
    public function show($uuid){
        $message = Message::with(['groupes', 'user:id,nom,prenom,email,telephone', 'users:id,nom,prenom,email,telephone', 'roles'])->where('uuid', $uuid)->first();
        return $this->successResponse($message);
    }

    public function sendMail(Request $request)
    {
        $this->validate($request, [
            "service" => "required",
            "subject" => Rule::requiredIf($request->service == "email"),
            "contenu" => "required",
            "roles" => Rule::requiredIf(count($request->groupes) == 0 && count($request->users) == 0),
            "groupes" => Rule::requiredIf(count($request->roles) == 0 && count($request->users) == 0),
            "users" => Rule::requiredIf(count($request->groupes) == 0 && count($request->roles) == 0)
        ]);

        $message = Message::create(['uuid' => Str::uuid(), 'creator_id' => auth()->user()->id, 'subject'=> $request->subject ?? 'SMS', 'message_body' => $request->contenu]);

        $users = collect();
        if(count($request->roles) > 0){
            /**
             * Nous recupérons  les utilisateurs qui ont les rôles renseigner
             */
            $roles = $request->roles;
            $users_roles = User::whereHas('roles', function ($query) use($roles){
                $query->whereIn('id', $roles);
            })->get();
            $users = $users->merge($users_roles);

            $message->roles()->sync($roles);
        }

        if(count($request->groupes) > 0){
            /**
             * Nous recupérons  les utilisateurs qui appartiennent aux groupes renseigner
             */
            $groupes = $request->groupes;
            $users_groupes = User::whereHas('groupe_utilisateurs', function ($query) use($groupes){
                $query->whereIn('id', $groupes);
            })->get();
            $users = $users->merge($users_groupes);
            $message->groupes()->sync($groupes);
        }

        if(count($request->users) > 0){
                /**
             * Nous recupérons  les utilisateurs dont l'id a été renseigner
             */
            $users_ = User::whereIn('id', $request->users)->get();
            $users = $users->merge($users_);
            $message->users()->sync($request->users);
        }
        // S'il s'agit des emails, nous les enverrons ici
        foreach ($users as $user) {
            if($request->service == "email"){
                if($user->email != ""){
                    $when = now()->addMinutes(1);
                    Mail::to($user->email)->cc('contrat@medicasure.com')->later($when, new MessageSend($user, $request->subject, $request->contenu));
                }
            }elseif($request->service == "sms"){
                if($user->telephone != ""){
                    sendSMS($user->telephone, strip_tags($request->contenu));
                }
            }
        }

        return $this->successResponse($message);

    }

}
