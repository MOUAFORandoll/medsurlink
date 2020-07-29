<?php

namespace App\Mail\Facture;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class MailRappel extends Mailable
{
    use Queueable, SerializesModels;
    public $facture;
    public $souscripteur;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($facture,$souscripteur)
    {
        $this->facture = $facture;
        $this->souscripteur = $souscripteur;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('RAPPEL FACTURES NON RÉGLÉES')
                    ->cc('comptabilite@medicasure.com')
                    ->markdown('emails.factures.rappel');
    }
}
