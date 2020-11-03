<?php

namespace App\Channels;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Notifications\Notification;

class SmsChannel
{
    protected $base_uri = 'smartsms.smartworldafriq.com';
//    protected $base_uri = 'http://193.105.74.159/api/v3/sendsms/json';

    private $login = 'medsur';
    private $password = 'MediCasure20';
    private $json = [];

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

        $this->json = [
            'authentication' => [
                "username" => $this->login,
                "password" => $this->password
            ],
            "messages" => array(
                [
                    "sender" => $details['from'],
                    "text" => $details['message'],
                    "type" => "longSMS",
                    "datacoding" => "8",
                    "recipients" => array(
                        [
                            "gsm" => $details['to'],
                        ]
                    )
                ]
            ),
        ];


        // Send notification to the $notifiable instance...
        $client = new Client([
            'base_uri' => $this->base_uri
        ]);

        try{
            $client->request(
                'POST',
                $this->base_uri,
                [
                    'json' => $this->json
                ]
            );
        } catch (Exception $ex) {}
    }
}
