<?php

namespace App\Notifications;

use App\Mail\AlerteEmail;
use App\Models\Alerte;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;

class AlerteNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    private $subject, $alerte;
    public function __construct($subject, Alerte $alerte)
    {
        $this->subject = $subject;
        $this->alerte = $alerte;
        $when = now()->addMinutes(1);
        $this->delay($when);
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        //return new AlerteEmail($this->subject, $this->alerte);
        return (new MailMessage)->subject($this->subject)->view('emails.alertes.send-notification', ['alerte' => $this->alerte]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            "id" => $this->alerte->id,
            "statut_id" => $this->alerte->statut_id,
            "plainte" => $this->alerte->plainte,
            "uuid" => $this->alerte->uuid,
            "niveau_urgence_id" => $this->alerte->niveau_urgence_id,
            "creator" => [
                "id" => $this->alerte->creator->id,
                "name" => $this->alerte->creator->name,
            ],
            "patient" => [
                "id" => $this->alerte->patient->id,
                "name" => $this->alerte->patient->name,
            ]
        ];
    }

    public function broadcastOn()
    {
        return ['news-action'];
    }

    public function broadcastAs()
    {
        return 'news-action';
    }
}
