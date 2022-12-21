<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\SlackMessage;

class SouscriptionAlert extends Notification
{
    use Queueable;
    private $message;
    private $sender;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($message,$sender=null)
    {
        $this->message = $message;
        
        if(!is_null($sender)) {
            $this->sender = $sender;
        } else {
            $this->sender =  'MEDSURLINK';
        }
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['slack'];
    }

    /**
     * Get the Slack representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\SlackMessage
     */
    public function toSlack($notifiable)
    {
        return (new SlackMessage)
                    ->from($this->sender)
                    ->content($this->message)
                    ->linkNames();
    }
}
