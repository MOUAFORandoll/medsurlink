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
    public $total;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($facture,$souscripteur,$path,$total)
    {
        $this->facture = $facture;
        $this->souscripteur = $souscripteur;
        $this->path = $path;
        $this->total = $total;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('RAPPEL FACTURES NON RÉGLÉES')
            ->from('no-reply@medsurlink.com')
            ->bcc('comptabilite@medicasure.com','Comptabilite')
            ->markdown('emails.factures.rappel')
            ->attach(public_path($this->path), [
                'mime' => 'application/pdf',
            ]);
    }
}
