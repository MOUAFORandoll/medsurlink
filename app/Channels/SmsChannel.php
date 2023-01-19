<?php

namespace App\Channels;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Notifications\Notification;

class SmsChannel
{
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


        // Send notification to the $notifiable instance...
        $client = new Client(['base_uri' => $this->base_uri]);

        try{
            $client->request('POST', $this->base_uri, [
                "user" => $this->login,
                "password" => $this->password,
                "senderid" => $details['from'],
                "sms" => $details['message'],
                "mobiles" => $details['to']
            ]);
        } catch (Exception $ex) {}
    }
}
