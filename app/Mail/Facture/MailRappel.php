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
    public $path;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($facture,$souscripteur,$path)
    {
        $this->facture = $facture;
        $this->souscripteur = $souscripteur;
        $this->path = $path;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('RAPPEL FACTURES NON RÉGLÉES')
            ->from('medsurlink@medicasure.com')
            ->bcc('comptabilite@medicasure.com','Comptabilite')
            ->markdown('emails.factures.rappel')
            ->attach(public_path($this->path), [
                'mime' => 'application/pdf',
            ]);
    }
}
