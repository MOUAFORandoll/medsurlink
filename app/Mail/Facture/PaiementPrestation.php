<?php

namespace App\Mail\Facture;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PaiementPrestation extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $pdf, $user, $patient, $prestation;

    public function __construct($pdf, $user, $patient, $prestation ="actes médicaux")
    {
        $this->pdf = $pdf;
        $this->user = $user;
        $this->patient = $patient;
        $this->prestation = $prestation;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(config('mail.from.address'))->subject("Reçu de $this->prestation")
                ->markdown('emails.Souscripteur.paiementPrestation')
                ->attachData($this->pdf,"$this->prestation du ".date('d-m-Y').".pdf");
    }
}
