<?php

namespace App\Mail\Facture;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AchatOffre extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $pdf, $user, $cim_title;

    public function __construct($pdf, $user, $cim_title)
    {
        $this->pdf = $pdf;
        $this->user = $user;
        $this->cim_title = $cim_title;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(config('mail.from.address'))->subject("Commande de l'offre $this->cim_title")
                ->markdown('emails.Souscripteur.factureOffre')
                ->attachData($this->pdf,"$this->cim_title du ".date('d-m-Y').".pdf");
    }
}


