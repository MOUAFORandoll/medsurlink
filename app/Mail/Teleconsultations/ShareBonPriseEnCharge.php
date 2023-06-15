<?php

namespace App\Mail\Teleconsultations;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ShareBonPriseEnCharge extends Mailable
{
    use Queueable, SerializesModels;
    public $subject, $contenu, $route;

    /**
     * Create a new contenu instance.
     *
     * @return void
     */
    public function __construct($subject, $contenu, $route)
    {
        $this->subject= $subject;
        $this->contenu = $contenu;
        $this->route = $route;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(config('mail.from.address'))->subject($this->subject)->view('emails.teleconsultations.share');
    }
}
