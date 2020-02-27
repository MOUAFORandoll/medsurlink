<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use App\Channels\SmsChannel;
use Illuminate\Notifications\Notification;

class SendSMS extends Notification
{
    use Queueable;

    private $message;
    private $sender;

    /**
     * Create a new notification instance.
     *
     * @param $message
     * @param string $sender
     */
    public function __construct($message, $sender = null)
    {
        $this->message = $message;

        if(!is_null($sender)) {

            if(strlen($sender) > 11) {
                $arr = explode(" ", $sender);

                $sender = $arr[0] ." ". ucfirst($arr[1][0]);
            }

            $this->sender = $sender;
        } else {
            $this->sender =  'Medicasure';
//            $this->sender =  config('app.name', 'Medicasure');
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
        return [SmsChannel::class];
    }

    /**
     * Get the SMS representation of the notification.
     *
     * @param $notifiable
     * @return array
     */
    public function toSms($notifiable)
    {
        return [
            'from' => $this->sender,
            'to' => $notifiable->telephone,
            'message' => $this->message
        ];
    }
}
