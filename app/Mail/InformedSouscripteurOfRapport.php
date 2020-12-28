<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class InformedSouscripteurOfRapport extends Mailable
{
    use Queueable, SerializesModels;
    public $souscripteur;
    public $patient;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($souscripteur,$patient)
    {
        $this->souscripteur = $souscripteur;
        $this->patient = $patient;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Medsurlink - Mise à jour des informations médicales')
            ->markdown('emails.rapport.informedSouscripteur');
    }
}
