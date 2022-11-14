<?php

namespace App\Mail\Rdv;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RappelSouscripteur extends Mailable
{
    use Queueable, SerializesModels;
    public $rdv;
    public $souscripteur;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($rdv,$souscripteur)
    {
        $this->rdv = $rdv;
        $this->souscripteur = $souscripteur;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Rendez-vous médical '.strtoupper($this->rdv->patient->nom).'  '.ucfirst($this->rdv->patient->prenom) )
            ->from(config('mail.from.address'))
            ->bcc('medsurlink@medicasure.com')
            ->markdown('emails.Rdv.RappelSouscripteur');
    }
}
