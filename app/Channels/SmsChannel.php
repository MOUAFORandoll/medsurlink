<?php

namespace App\Channels;

use App\Traits\RequestService;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Notifications\Notification;

class SmsChannel
{
    use RequestService;
    protected $base_uri = "https://smsvas.com/bulk/public/index.php/api/v1/sendsms";

    private $login = 'kadji@medicasure.com';
    private $password = 'MediCasure';

    /**
     * Send the given notification.
     *
     * @param  mixed $notifiable
     * @param Notification $notification
     * @return void
     * @throws GuzzleException
     */
    public function send($notifiable, Notification $notification)
    {
        $details = $notification->toSms($notifiable);

        try{
            $this->request('POST', "{$this->base_uri}", [
                "user" => $this->login,
                "password" => $this->password,
                "senderid" => $details['from'],
                "sms" => $details['message'],
                "mobiles" => $details['to']
            ]);
        } catch (\Exception $ex) {
            \Log::alert("Erreur d'envoie de SMS", $ex->getMessage());
        }
    }
}
