<?php

namespace App\Mail;

use App\Models\Alerte;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AlerteEmail extends Mailable
{
    use Queueable, SerializesModels;
    public $subject, $alerte;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($subject, Alerte $alerte)
    {
        $this->subject= $subject;
        $this->alerte = $alerte;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(config('mail.from.address'))
                    ->subject($this->subject)
                    ->markdown('emails.alertes.send-notification');
    }
}
