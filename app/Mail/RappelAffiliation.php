<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RappelAffiliation extends Mailable
{
    use Queueable, SerializesModels;

    public $souscripteur;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($souscripteur)
    {
        $this->souscripteur = $souscripteur;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Rappel de Souscription')
            ->markdown('emails.Souscripteur.rappelAddPatient');
    }
}
