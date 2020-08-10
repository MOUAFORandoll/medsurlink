<?php

namespace App\Mail\Facture;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class MailRecouvrement extends Mailable
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
        return $this->subject('Etat Financier '.strtoupper($this->souscripteur->user->nom).'  '.ucfirst($this->souscripteur->user->prenom).' Souscripteur au '. now()->format('d-m-yy'))
                    ->cc('comptabilite@medicasure.com')
                    ->markdown('emails.factures.recouvrement');

    }
}
