<?php

namespace App\Listeners;

use Illuminate\Notifications\Events\NotificationSent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class LogNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  NotificationSent  $event
     * @return void
     */
    public function handle(NotificationSent $event)
    {
        // This is just a way for us to view information
        Log::info('Information of the event', [
            'response' => $event->response,
            'notifiable' => $event->notifiable,
            'notification' => $event->notification,
            'channel' => $event->channel,
            'event' => $event,
        ]);
        // Here we have to handle after sending the message
        // Do something here

        // Note: Remember that it is not just the SMS which may be send
    }
}
