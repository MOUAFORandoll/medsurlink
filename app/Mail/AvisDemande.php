<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AvisDemande extends Mailable
{
    use Queueable, SerializesModels;
    public $user;
    public $avis;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user,$avis)
    {
        $this->user= $user;
        $this->avis = $avis;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('avismedical@medicasure.com')
                    ->subject('Demande d\'avis médical')
                    ->markdown('emails.avis.demande');
    }
}
