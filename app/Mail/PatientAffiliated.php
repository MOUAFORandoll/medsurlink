<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PatientAffiliated extends Mailable
{
    use Queueable, SerializesModels;

    public $patient;
    public $souscripteur;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($souscripteur,$patient)
    {
        $this->patient = $patient;
        $this->souscripteur = $souscripteur;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.Souscripteur.patientAffilated')->subject("Ajout d'un patient");
    }
}
